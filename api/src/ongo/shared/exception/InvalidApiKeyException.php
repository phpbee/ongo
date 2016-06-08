<?php

namespace ongo\shared\exception;
	
final class InvalidApiKeyException extends \Exception {
	public function __construct($apiKey) {
       parent::__construct($apiKey . " is not valid");
   }
}
	
?>