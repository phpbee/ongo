<?php

$config = include __DIR__.'/../providers.php';
$config['providers'][] = ['class'=>'Silex\Provider\MonologServiceProvider','values'=>['monolog.logfile'=>BASEPATH.'/storage/logs/app-'.ENVIRONMENT.'.log']];
$config['providers'][] = ['class'=>'Silex\Provider\WebProfilerServiceProvider','values'=>['profiler.cache_dir'=>BASEPATH.'/storage/cache/profiler']];

return $config;
