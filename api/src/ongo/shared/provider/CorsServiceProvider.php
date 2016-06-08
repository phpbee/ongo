<?php

namespace ongo\shared\provider;

use ongo\shared\service\CorsService;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class CorsServiceProvider implements ServiceProviderInterface {
	public function register(Application $app) {
		$app["cors"] = $app->share(function ($app) {
			return new CorsService(
				$app["cors.path"],
				$app["cors.allow_origin"],
				$app["cors.allow_methods"],
				$app["cors.allow_headers"],
				$app["cors.max_age"]	
			);
        });
    }

    public function boot(Application $app) {
		$app->before(function (Request $request) use ($app) {
			if ($request->getMethod() == "OPTIONS" && $app["cors"]->isCors($request)) {
				$response = new Response("OK", 200);
				$app["cors"]->setHeaders($response);
				return $response;
			}
		}, Application::EARLY_EVENT);
		$app->after(function (Request $request, Response $response) use ($app) {
			if ($app["cors"]->isCors($request))
				$app["cors"]->setHeaders($response);
		});
    }
}

?>