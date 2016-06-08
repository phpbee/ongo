<?php

namespace ongo\shared\exception;

final class InvalidApiUserPasswordException extends \Exception
{
    public function __construct($username)
    {
        parent::__construct("Apiuser username " . $username . " is not unique");
    }
}

?>