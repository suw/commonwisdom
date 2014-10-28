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

$app->get('/', function() use ($app) {
    return $app['twig']->loadTemplate('main.html')->render([]);
});


$app->get('/list/', function () use ($app) {
    $controller = new ViewFileController($app);
    return $controller->renderFileList();
});

$app->get('/edit/{fileName}', function ($fileName) use ($app) {
    $controller = new ViewFileController($app);
    return $controller->renderFile($fileName);
});

$app->post('/edit/{fileName}', function (Request $request, $fileName) use ($app) {
    $controller = new ViewFileController($app);
    return $controller->saveAndRenderFile($request, $fileName);
});

return $app;
