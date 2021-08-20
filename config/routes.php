<?php

use Home\CmsMini\Router;

use App\Controller\HomeController;
use App\Controller\Patterns;
use App\Controller\UserController;

Router::get('', HomeController::class);
Router::get('/about', HomeController::class, 'about');
Router::get('/patterns/composite', Patterns::class, 'composite');

Router::post('/register', UserController::class, 'store');
Router::any('/login', UserController::class, 'login');
Router::get('/logout', UserController::class, 'logout');
