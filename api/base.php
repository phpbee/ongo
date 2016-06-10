<?
$_POST=array_merge($_POST,$_GET);


class base_class implements ArrayAccess {
    function base_class() {
        mydump ("base class constructor");
    }

    function offsetExists ($offset) {
        $arrayValues=$this->getValues();
        return isset($arrayValues[$offset]);
    }

    function offsetGet($offset) {
        $arrayValues=$this->getValues();
        return $arrayValues[$offset];
    }

    function offsetSet ( $offset , $value ) {
        $this->$offset = $value;
    }

    function offsetUnset ( $offset ) {
        unset($this->$offset);
    }


    function actions_add($_POST,$extvals=false,$nocheck=false,$noreturn=false) {
        $this->fill_from_form($_POST);
        $this->fill_from_array($extvals);
        if ($retr=$this->checkfill()) {
            $href = $_SERVER["HTTP_REFERER"];
            $errmessage=(serialize($retr));
            $errvalues=(serialize($_POST));
            $message="please check fields";
        } else {
            $this->setID($this->insert_into_db(true));
            if (!isset($_POST['_nolinked'])) {
                $this->fill_linked_from_form();
                $this->store_linked();
            }
            if (!$this->getID()>0) {
                $href = $_SERVER["HTTP_REFERER"];
                $errmessage=(serialize($retr));
                $errvalues=(serialize($_POST));
                $message="try again";
            }

        }
        if (!$noreturn) $this->actions_return($href,$message,$errmessage,$errvalues,$this->getID());
    }
    function actions_edit($_POST=false,$extvals=false,$nocheck=false,$noreturn=false) {
        $this->fill_from_form($_POST);
        $this->fill_from_array($extvals);
        if (@$retr=$this->checkfill() && $nocheck!='nocheck') {
            $href = $_SERVER["HTTP_REFERER"];
            $errmessage=(serialize($retr));
            $errvalues=(serialize($_POST));
            $message="please check fields";
        } else {
            if (!isset($_POST['_nolinked'])) {
                $this->fill_linked_from_form();
                $this->store_linked();
            }
            $result=$this->update_db();
        }
        if (!$noreturn) $this->actions_return($href,$message,$errmessage,$errvalues,$this->getID());
    }

    function actions_delete($_POST=false,$extvals=false) {
        $_id=$_POST["_id"];
        $result=$this->delete_from_db();
        $this->actions_return($href,$message,$errmessage,$errvalues);
    }
    function actions_return($href=false,$message=false, $errmessage=false, $errvalues=false,$objid=false) {
        $NOFORWARD=0;
        global $_POST;
        global $_SERVER;

        if (!$href) {
            if (isset($_backurl)) {
                $href = $_backurl;
            } else if (isset($_POST["_backurl"] )) {
                $href = $_POST["_backurl"];
            } else {
                $href = $_SERVER["HTTP_REFERER"];
            }
            if ($href=='_none') return;
        }
        $href=eregi_replace("\&?message=(.*)\&?","",$href);
        $href=eregi_replace("\&?errmessage=(.*)\&?","",$href);
        $href=eregi_replace("\&?errvalues=(.*)\&?","",$href);
        $href=eregi_replace("\&?thisid=(.*)\&?","",$href);
        $message=urlencode($message);
        $errmessage=urlencode($errmessage);
        $errvalues=urlencode($errvalues);
        if ($NOFORWARD!=1 && !$_POST['_NOFORWARD']) {
            @header("Location: $href".(ereg('\?',$href)?'&':'?')."message=$message&errmessage=$errmessage&errvalues=$errvalues&thisid=".$this->getID()."&$this->_idfield=".$this->getID());
            echo "<META HTTP-EQUIV=\"refresh\" CONTENT=\"0; URL=$href".(ereg('\?',$href)?'&':'?')."message=$message&errmessage=$errmessage&errvalues=$errvalues&thisid=".$this->getID()."&$this->_idfield=".$this->getID()."\">";
        }
        else {
            mydump($href);
            mydump($message);
            mydump($errmessage);
            mydump($errvalues);
            mydump($objid);
        }
    }

    function init($id=false) {
        $que="select * from $this->_table_name limit 0";
        $res=mysql_query_ok($que);
        if ($res=mysql_query_ok($que)) {
            $this->equals=array();
            while ($field=mysql_fetch_field($res)) {
                $this->equals[$field->name]=$field->name;
                $this->{$field->name}=false;
                switch ($field->type) {
                    case 'int':
                        settype($this->{$field->name},"integer");
                        break;
                    case 'real':
                        settype($this->{$field->name},"float");
                        break;
                    default:
                }
            }
        }

        if ($id) {
            $this->select_from_db_byid($id);
        }
    }

    function store_linked() {
        if ($this->linked) {
            $_deleted=array();
            foreach ($this->linked as $_classname => $obj ) {
                switch (@$obj["linktype"]) {
                    case 'many2many':
                        //$_classname=$obj['linkclass'];
                        //$_newclassname=$_classname;
                        //$_incname=LIBDIR.'/classes/'.$_classname.'_class.php';

                        $_newclassname=$obj['linkclass'];
                        loadclass($_newclassname);
                        if (!isset($_deleted[$obj[linktable]])) {
                            @$que=" delete from ".$obj[linktable]." where ".$obj["sourcefield"]."=".$this->getID();
                            mysql_query_ok($que);
                            $_deleted[$obj[linktable]]=1;
                        }

                        foreach ($this->{$_classname} as $fkey=>$fobj) {
                            $que=" insert into ".$obj[linktable]." (".$obj["sourcefield"].",".$obj["targetfield"].") values (".$this->getID().",".$fobj->getID().")";
                            mysql_query_ok($que);
                        }



                }
            }
        }
    }
    function fill_linked_from_form() {
        if (isset($this->linked)) {
            foreach ($this->linked as $_classname => $obj ) {
                //echo "class: $_classname<br>";
                switch (@$obj["linktype"]) {
                    case 'many2many':
                        $_newclassname=$obj['linkclass'];
                        //$_newclassname=$_classname;
                        loadclass($_newclassname);

                        $this->{$_classname}=Array();
                        if (isset($_POST[$_newclassname])) {
                            reset($this->{$_classname});
                            $this->{$_classname}=get_array_byindex($_newclassname,$_POST[$_newclassname]);
                        }

                        break;
                }
            }
        }
    }
    function fill_linked() {
        foreach ($this->linked as $_classname => $obj ) {
            //echo "class: $_classname<br>";
            switch ($obj["linktype"]) {
                case 'one2one':
                    $_newclassname=$obj['linkclass'];
                    loadclass($_newclassname);

                    $this->{$_newclassname}=new $_newclassname($this->{$obj["targetfield"]});

                    break;
                case 'many2many':
                    $_newclassname=$obj['linkclass'];
                    loadclass($_newclassname);

                    $que="select ".$obj["targetfield"]." from ".$obj[linktable]." where ".$obj["sourcefield"]."=".$this->getID()." ";
                    //mydump ($que);
                    //if (isset($obj[extwhere]) || isset($obj["idwherefield"])) {
                    if (isset($obj["idwherefield"])) {
                        $que.=" and (";
                        if (isset($obj["idwherefield"])) {
                            $que.=$obj["idwherefield"]."=".$this->getID();
                        }
                        /*
                        if (isset($obj[extwhere])) {
                            $que.=" ".sprintf($obj[extwhere]);
                        }
                        */
                        $que.=") ";
                    }
                    $res=mysql_query_ok($que);

                    $this->{$_classname}=Array();

                    while (@$st=mysql_fetch_object($res)) {
                        $class=new $_newclassname($st->{$obj["targetfield"]});
                        array_push($this->{$_classname},$class);
                    }
                    //echo "<pre>",print_r(${$_classname}),"</pre><br>";
                    break;
            }
        }
    }

    function fill_from_array($ar=false) {
        if ($ar) {
            foreach($ar as $key => $value) {
                @$this->$key=$value;
            }
        }
    }
    function fill_from_form () {
        global $_POST;
        reset($this->equals);
        while (list($db_name,$form_name)=each ($this->equals)) {
            if (isset($_POST[$form_name]) ) {
                @$this->$db_name=$_POST[$form_name];
            }
        }
    }
    function checkfill($logincheck=true) {
        //types: login, email, password, nonzero, req, date, is_date, size

        global $_POST;
        if (isset($this->checkfields)) {
            $rarr = array ();
            foreach ($this->checkfields as $field=>$type) {

                switch ($type[0]) {
                    case 'size':
                        if (!isset($this->$field) || strlen($this->$field)>$type[1]  ) {
                            //$rarr["error_".$field].="value $field is empty";
                            $rarr["error_".$field].="<font color=red><b>error size, should be less  ".$type[1]." </b></font>";
                        }
                        break;
                    default:
                        break;
                }
                $v = explode(',', $type);
                foreach($v as $type) {
                    $type= trim($type);
                    switch ($type) {
                        case 'login':
                            if ($logincheck) {
                                $que="select count(*) as cnt from $this->_table_name where $field='".$this->$field."' ";
                                if ($this->getID()>0) $que.=" and $this->_idfield!=".$this->getID();
                                if (mysql_result(mysql_query_ok($que),0,0)>0 ) {
                                    $rarr["error_".$field].="<font color=red><b>login already in use (".$this->$field.").</b></font>";
                                } else if (!isset($this->$field) || ( is_string($this->$field) && !$this->$field>'')) {
                                    $rarr["error_".$field].="<font color=red><b>empty login.</b></font>";
                                }
                            }
                            break;
                        case 'email':
                            if (!checkmail($this->$field) ) {
                                $rarr["error_".$field].="<br><font color=red><b>invalid email ".$this->$field." </b></font>";
                            }
                            break;
                        case 'password':
                            if ($_POST[$this->_passwordfields[p1]]=='' || $_POST[$this->_passwordfields[p2]]=='' || !$this->$field>'') {
                                $rarr["error_".$field].="<font color=red><b>empty password</b></font>";
                            }
                            if ($_POST[$this->_passwordfields[p1]]!=$_POST[$this->_passwordfields[p2]]) {
                                $rarr["error_".$field].="<font color=red><b>different values.</b></font>";
                            }
                            break;
                        case 'nonzero':
                            if (isset($this->$field) &&  ((is_int($this->$field) && $this->$field==0) || (is_string($this->$field) && $this->$field=="0" )) ) {
                                $rarr["error_".$field].="<font color=red><b>requered field missed</b></font>";
                            }
                            break;
                        case 'req':
                            if (!isset($this->$field) || ( is_string($this->$field) && !$this->$field>'')  ) {
                                $rarr["error_".$field].="<font color=red><b>requered field missed</b></font>";
                            }
                            break;
                        case 'date':
                            $dt=explode("/",$this->$field);
                            if (!isset($this->$field) || $dt==-1 || !checkdate($dt[1],$dt[0],$dt[2])) {
                                $rarr["error_".$field].="<font color=red><b>Error date format</b></font>";
                            }
                            break;

                        case 'is_date':
                            if (isset($this->$field) && trim($this->$field)!="") {
                                $dt=explode(".",$this->$field);
                                if ($dt==-1 || !checkdate($dt[1],$dt[0],$dt[2])) {
                                    $rarr["error_".$field].="<font color=red><b>Error date format</b></font>";
                                }
                            }

                            break;
                        default:
                    }
                }

            }
        }
        return @sizeof($rarr)>0 ? $rarr : false;
    }
    function delete_from_db () {
        $que=" delete from $this->_table_name where $this->_idfield=".$this->getID();
        $res=mysql_query_ok($que);
        return mysql_affected_rows();
    }
    function select_from_db_byid($id, $nodateconvert=true) {
        $this->select_from_db(" where $this->_idfield=".$id, $nodateconvert);
    }
    function select_from_db ($wh_que, $nodateconvert=true) {
        $que=" select * from ".$this->_table_name." $wh_que  LIMIT 1";
        $res=mysql_query_ok($que);
        if ($res) {
            $info=array();
            for ($i=0;$i< mysql_num_fields($res);$i++) {
                $meta=(mysql_fetch_field($res));
                $info[$meta->name]=$meta->type;
            }
            $obj=mysql_fetch_object($res);
            foreach ($this->equals as $key=>$value) {

                if (!isset($info[$key])) continue;

                $this->$key=$obj->$key;
                if ($nodateconvert==false) {
                    if ($info[$key]=='date' && $this->$key>0) {
                        $rname="real_".$key;
                        $this->$rname=$this->$key;
                        $this->$key=date("d.m.Y",strtotime($this->$key));
                    }
                    if ($info[$key]=='datetime' && $this->$key>0 ) {
                        $rname="real_".$key;
                        $this->$rname=$this->$key;
                        $this->$key=date("d.m.Y H:i",strtotime($this->$key));
                    }
                }
            }
        }
        //exit();
        return $res;
    }

    function update_db () {
        $updates = array ();
        reset($this->equals);
        while ( list($name,$form_name) = each($this->equals)){
            $value=$this->$name;
            //if ($form_name!='' && $name!=$this->_datefield && $value!='0000-00-00 00:00:00'){	
            if ($form_name!=''){
                if ( is_string($value)) $value="'".mysql_real_escape_string($value)."'";
                //if ( $name==$this->_datefield) $value="now()";
                if ( $value == null  ) $value="''";
                array_push($updates,"$name=$value");
            }
        }
        $updates_list= join(", ",$updates);
        $que=" update ".$this->_table_name."  set $updates_list  where $this->_idfield=".$this->getID();
        //mydump($que);
        //echo $que."<br>";
        //exit;
        //mydump($que);
        mysql_query_ok($que);
        if (mysql_errno()>0) {
            mydump($que,false,true);
            mydump(mysql_error(),false,true);
        }
        return mysql_affected_rows();
    }
    function insert_into_db ($dumpq=false) {
        //$this->setrighttypes();
        $fields = array ();
        $values = array ();
        reset($this->equals);
        while ( list($name,$form_name) = each($this->equals)){
            if ($form_name!='' && $name!=$this->_idfield){
                @$value=$this->$name;
                if ( is_string($value)  ) $value="'".mysql_real_escape_string($value)."'";
                if ( $name==$this->_datefield) $value="now()";
                if ( $value == null  ) $value="''";
                array_push($fields,$name);
                array_push($values,$value);
            } else if ( $name==$this->_datefield) {
                array_push($fields,$name);
                array_push($values,"now()");
            }
        }
        $fields_list= join(", ",$fields);
        $values_list= join(", ",$values);
        $que=" insert into ".$this->_table_name." ($fields_list) values ($values_list)";
        @mysql_query_ok($que);
        if ($dumpq) { mydump($que,false); mydump(mysql_error(),0); };
        return mysql_query_ok_insert_id();
    }

    function dump () {
        mydump($this);
    }

    function getID () {
        return $this->{$this->_idfield};
    }
    function setID ($id) {
        $this->{$this->_idfield}=$id;
        return;
    }

    function getValues() {
        $rr=get_object_vars($this);
        foreach ($rr as $key=>$value) {
            if (is_string($value) || is_numeric($value)) {
                $ret[$key]=$value;
            } else if (isset($this->_DBSETVALUES[$key]) && is_array($this->_DBSETVALUES[$key])) {
                $ret[$key]=$value;
                $ret[$key.'_Names']=array_keys($value);
            } else if (is_array($value) && is_object(($f=reset($value))) && method_exists($f,'getValues')) {
                foreach ($value as $v) {
                    $ret[$key][]=$v->getValues();
                }
            } else if (is_object($value) && method_exists($value,'getValues')) {
                $ret[$key]=$value->getValues();
            } else if (is_array($value) && !is_object(reset($value))) {
                $ret[$key]=$value;
            }
        }
        /*
        foreach ($this->_EQUALS as $key=>$field) {
            $ret[$field]=$this->$field;
        }
        */

        if (isset($this->_LINKED) && is_array($this->_LINKED)) foreach ($this->_LINKED as $mkey=>$link) {
            if (is_array($this->{$link[classname]}) && sizeof($this->{$link[classname]}>0)) foreach ($this->{$link[classname]} as $key=>$linkobj) {
                if (get_class($linkobj)==$link[classname]) $ret[$link[classname]][$key]=$linkobj->getValues();
            } else {
                $linkobj=$this->{$link[classname]};
                if (get_class($linkobj)==$link[classname]) $ret[$link[classname]]=$linkobj->getValues();
            }
        }
        return $ret;
    }





}
function plist($class){
    @$criteria= func_get_arg (1);
    @$page= func_get_arg (2);
    @$lst= func_get_arg (3);
    if ($page && $lst) $lim="LIMIT ".($page-1)*$lst.",".$lst." ";
    $que="select $this->_idfield  from $class->_table_name $criteria $lim";
    $res=mysql_query_ok($que);
    return $res;
}
function queryResult($que, $group=false) {
    $ret=array();
    if ($res=mysql_query_ok($que)) while ($o=mysql_fetch_assoc($res)) {
        if ($group) {
            foreach ($o as $k=>$v) {
                $ret[$k][]=$v;
            }
        } else {
            $ret[]=$o;
        }
    }
    return $ret;
}


?>