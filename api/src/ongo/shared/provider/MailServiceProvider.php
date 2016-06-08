<?php

namespace ongo\shared\provider;

use ongo\shared\service\mail\Mandrill;
use Silex\Application;
use Silex\ServiceProviderInterface;

final class MailServiceProvider implements ServiceProviderInterface {
	public function register(Application $app) {
		$app["mailservice"] = $app->share(function ($app) {
			return new Mandrill(new \Mandrill($app['mandrill.api_key']),
                $app['mail.from_email'],
                $app['mail.from_name']
                );
        });
    }

    public function boot(Application $app) {
    }
}

?>