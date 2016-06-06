<?php

return [
    'providers' => [
        ['class'=>'Silex\Provider\ServiceControllerServiceProvider'],
        ['class'=>'Silex\Provider\TwigServiceProvider','values' => ['twig.path' => [ APPPATH.'/views',APPPATH.'/templates']]],
        ['class'=>'Silex\Provider\UrlGeneratorServiceProvider'],
    ]
];