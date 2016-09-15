<?php

namespace ongo\shared\entity;

use ongo\shared\model\CountryModel;
use Doctrine\DBAL\Connection;

final class CountryEntity extends SerializableEntity
{
    /** @var  int */
    private $id;
    /** @var  string */
    private $name;
    /** @var  string */
    private $logo;    
    /** @var  string */
    private $flag;

    /**
     * CountryEntity constructor.
     * @param int $id
     * @param string $name
     * @param string $logo
     * @param string $flag
     */
    public function __construct($id, $name, $logo, $flag)
    {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
        $this->flag = $flag;
    }


    /**
     * @param array $array
     * @param Connection $dbConn
     * @return CountryEntity
     * @throws \ongo\shared\exception\InvalidIdException
     * @throws \ongo\shared\exception\MissingKeyException
     */
    public static function unserialize(array $array, Connection $dbConn)
    {
        static::validate($array, array("id"));
        $model = new CountryModel($dbConn);
        return $model->findById($array["id"]);
    }
    /**
     * @param Connection $dbConn
     * @param bool $deep
     * @return array
     */
    public function serialize(Connection $dbConn, $deep = true)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'logo' => $this->logo,
            'flag' => $this->flag,
        ];
    }
}
?>