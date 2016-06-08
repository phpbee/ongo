<?php

namespace ongo\shared\provider;

use ongo\shared\service\cache\AmazonElastiCacheClusterClientService;
use ongo\shared\service\cache\MemcachedService;
use Silex\Application;
use Silex\ServiceProviderInterface;

final class CacheServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app["cache"] = $app->share(function ($app) {
            if ('memcached' == strtolower($app["cache.type"])) {
                return new MemcachedService($app["cache.endpoint"], (isset($app["cache.key_prefix"])) ? $app["cache.key_prefix"] : null);
            }
            if ('amazonelasticache' == strtolower($app["cache.type"])) {
                return new AmazonElastiCacheClusterClientService($app["cache.endpoint"], (isset($app["cache.key_prefix"])) ? $app["cache.key_prefix"] : null);
            }
        });
    }

    public function boot(Application $app)
    {
    }
}

?>