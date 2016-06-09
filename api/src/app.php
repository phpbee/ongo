<?php

require_once(__DIR__ . "/bootstrap.php");

$app = new Silex\Application(array(
    "debug" => false
));
$db_options = array(
    "driver" => "pdo_mysql",
    "dbname" => $_ENV['MYSQL_DB'],
    "host" => $_ENV['MYSQL_HOST'],
    "user" => $_ENV['MYSQL_USER'],
    "charset" => "utf8",
);
if (isset($_ENV['MYSQL_PASSWORD'])) {
    $db_options["password"] = $_ENV['MYSQL_PASSWORD'];
}

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    "db.options" => $db_options
));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    "monolog.logfile" => "/var/log/silex/api.partners.ongophotos.com.log",
    "monolog.level" => Monolog\Logger::DEBUG
));
Symfony\Component\HttpKernel\Debug\ErrorHandler::register();


$app->register(new ongo\shared\provider\CacheServiceProvider(), array(
    "cache.type" => $_ENV['CACHE_TYPE'],
    "cache.endpoint" => $_ENV['CACHE_ENDPOINT'],
    "cache.key_prefix" => "api_"
));
$app->register(new ongo\shared\provider\AuthenticationServiceProvider(), array(
    "auth.memcache_object" => $app["cache"],
    "auth.db_object" => $app["db"]
));
$app->register(new ongo\shared\provider\CorsServiceProvider(), array(
    "cors.path" => "/^.*/",
    "cors.allow_origin" => "*",
    "cors.allow_methods" => "POST, GET, PUT, DELETE, OPTIONS",
    "cors.allow_headers" => "Accept, Content-Type, Authorization",
    "cors.max_age" => "600"
));
$app->register(new ongo\shared\provider\MailServiceProvider(), array(
    "mandrill.api_key"=>$_ENV['MANDRILL_KEY'],
    "mail.from_email"=>"noreply@ongophotos.com",
    "mail.from_name"=>"OnGoPhotos",
));
$app->before(function (Symfony\Component\HttpFoundation\Request $request) {
    if (strpos($request->headers->get("Content-Type"), "application/json") === 0) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});
$app->mount("/", new ongo\api\ControllerProvider());
return $app;

?>