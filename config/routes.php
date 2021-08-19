<?php

use Home\CmsMini\Router;

use App\Controller\Home;
use App\Controller\Patterns;
use App\Controller\UserController;

Router::get('', Home::class);
Router::get('/patterns/composite', Patterns::class, 'composite');

Router::post('/register', UserController::class, 'store');
Router::any('/login', UserController::class, 'login');
Router::get('/logout', UserController::class, 'logout');
