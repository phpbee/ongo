<?php

namespace ongo\api\exception;
	
final class AccessDelegationNotSupportedException extends \Exception {
	public function __construct() {
       parent::__construct();
   }
}
	
?>