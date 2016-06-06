<?php
// Silex stuff
use Silex\Application;
use Symfony\Component\Debug\Debug;

// Application
use MJanssen\Provider\ServiceRegisterProvider;
use MJanssen\Provider\RoutingServiceProvider;
use Whoops\Provider\Silex\WhoopsServiceProvider;
use WebComposer\Provider\ConfigServiceProvider;
use WebComposer\Provider\ErrorHandlerServiceProvider;

//register silex app
$app = new Application();
$app['config.path'] = APPPATH;

$app->register(new ConfigServiceProvider());

$app['config']->loadFile('app.php');
$app['config']->loadFile('controllers.php');
$app['config']->loadFile('providers.php');
$app['config']->loadFile('routes.json');

$app['debug'] = $app['config']->getItem('debug');

$app->register(new ErrorHandlerServiceProvider());

if( $app['debug'] )
{
    // manually register whoops error handler
    $app->register(new WhoopsServiceProvider(),[
        'whoops.error_page_handler' => 'sublime'
    ]);
}
else
{
    $app['twig.options'] = ['cache' => BASEPATH.'/storage/cache/twig'];
}

$serviceRegisterProvider = new ServiceRegisterProvider();
$serviceRegisterProvider->registerServiceProviders($app, $app['config']->getItem('providers'));

foreach ($app['config']->getItem('controllers') as $key => $controller) 
{
    $app['controller.'.$key] = $app->share(function() use ( $controller, $app ) {
        return new $controller($app);
    });
}

$router = new RoutingServiceProvider();
$router->addRoutes($app, $app['config']->getItem('routes'));

return $app;