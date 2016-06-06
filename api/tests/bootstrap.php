<?php
/**
 * Define environment
 * One of production,development,test
 */
define('ENVIRONMENT', 'test');
define('BASEPATH', dirname(__DIR__));
define('WEBPATH', __DIR__);
define('APPPATH', BASEPATH.'/app');

date_default_timezone_set ('Europe/Amsterdam');

/**
 * Simple test harness for the time being, will delete it when I TDD out the 
 * massive spike that was the development of this provider :)
 */
$loader = require __DIR__."/../vendor/autoload.php";
$loader->add('AppBundle\Tests', __DIR__);