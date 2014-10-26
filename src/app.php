<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use suw\commonwisdom\Controllers\ViewFileController;

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/views',
));


$app->get('/view/{fileName}', function ($fileName) use ($app) {
    $controller = new ViewFileController($app);
    return $controller->renderFile($fileName);
});

return $app;
