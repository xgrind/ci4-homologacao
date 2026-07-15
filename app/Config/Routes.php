<?php

use App\Controllers\PostController;
use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('posts/import', [PostController::class, 'import'], [
    'as' => 'post.import',
]);

$routes->get('posts/truncate', [PostController::class, 'truncate'], [
    'as' => 'post.truncate',
]);


$routes->presenter('posts', ['controller' => 'PostController']);
