<?php

namespace ongo\shared\provider;

use ongo\shared\service\AuthenticationService;
use Silex\Application;
use Silex\ServiceProviderInterface;

final class AuthenticationServiceProvider implements ServiceProviderInterface {
	public function register(Application $app) {
		$app["auth"] = $app->share(function ($app) {
			return new AuthenticationService($app["auth.memcache_object"], $app["auth.db_object"]);
        });
    }

    public function boot(Application $app) {
		$app->before(function() use ($app) {
	    	$app["auth"]->setRequest($app["request"]);
	    });
    }
}

?>