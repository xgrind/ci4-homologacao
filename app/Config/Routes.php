<?php

use App\Controllers\DecretoController;
use App\Controllers\PostController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('posts/truncate', [PostController::class, 'truncate'], ['as' => 'post.truncate']);
$routes->presenter('posts', ['controller' => 'PostController']);


$routes->get('decretos/lista', [DecretoController::class, 'list'], ['as' => 'decreto.lista']);
$routes->presenter('decretos', ['controller' => 'DecretoController']);
