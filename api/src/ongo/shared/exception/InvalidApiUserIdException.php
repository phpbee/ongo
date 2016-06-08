<?php

namespace ongo\shared\exception;

final class InvalidApiUserIdException extends \Exception
{
    public function __construct($username)
    {
        parent::__construct("ApiUser Id " . $username . " is not valid");
    }
}

?>