<?php

namespace ongo\shared\exception;
	
final class InvalidAuthenticationServiceVersionException extends \Exception {
	public function __construct($version) {
       parent::__construct($version . " is not valid");
   }
}
	
?>