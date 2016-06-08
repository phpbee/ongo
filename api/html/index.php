<?php
chdir(dirname(__DIR__));
$_SERVER['REQUEST_URI'] = preg_replace('/^\/api/', '', $_SERVER['REQUEST_URI']);


$app = require_once("src/app.php");
$app->run();
