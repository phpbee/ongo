<?php

namespace ongo\shared\exception;
	
class InvalidIdException extends \Exception {
	public function __construct($id) {
       parent::__construct($id . " is not valid");
   }
}
