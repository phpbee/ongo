<?php

namespace ongo\shared\exception;
	
final class InvalidIdException extends \Exception {
	public function __construct($id) {
       parent::__construct($id . " is not valid");
   }
}
