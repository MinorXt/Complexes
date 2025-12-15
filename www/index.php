<?php

use DI\Container;
use Slim\Factory\AppFactory;
use Slim\Views\PhpRenderer;
use Src\Controllers\ApiController;
use Src\Controllers\HomeController;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$container->set(PhpRenderer::class, function () {
    return new PhpRenderer(__DIR__ . '/templates');
});

ORM::configure('mysql:host=database;dbname=docker');
ORM::configure('username', 'root');
ORM::configure('password', 'tiger');

$app->get('/', [HomeController::class, 'index']);
$app->get('/filter', [HomeController::class, 'filter']);
$app->get('/apartment/{id}', [HomeController::class, 'apartment']);
$app->get('/complex/map/{complex_slug}', [HomeController::class, 'showMap']);

$app->get('/api/import', [ApiController::class, 'import']);

$app->run();