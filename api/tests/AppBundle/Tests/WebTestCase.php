<?php

namespace AppBundle\Tests;

use Silex\WebTestCase as TestCase;

/**
 * TestCase
 * Base class for all unit testing suites
 *
 * @package WebComposer
 * @author Izzia Raffaele <izziaraffaele@gmail.com>
 * @copyright 2015 Izzia Raffaele
 */
class WebTestCase extends TestCase{
    /**
     * Create the application
     * 
     * @return Silex\Application 
     */
    public function createApplication()
    {
        $app = require(APPPATH.'/app.php');
        $app['debug'] = true;
        $app['exception_handler']->disable();
        return $app;
    }
}