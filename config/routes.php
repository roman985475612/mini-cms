<?php

use Home\CmsMini\Router;

use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\Patterns;
use App\Controller\AdminController;
use App\Controller\AuthController;

Router::get('', HomeController::class);
Router::get('/about', HomeController::class, 'about');
Router::get('/services', HomeController::class, 'services');
Router::get('/contact', HomeController::class, 'contact');
Router::post('/contact', HomeController::class, 'contactStore');

Router::get('/blog', BlogController::class);
Router::get('/blog/<id>', BlogController::class, 'show');
Router::get('/category/<id>', BlogController::class, 'category');

Router::post('/signup', AuthController::class, 'signup');
Router::any('/login', AuthController::class, 'login');
Router::get('/logout', AuthController::class, 'logout');
Router::get('/admin', AdminController::class);

Router::get('/patterns/composite', Patterns::class, 'composite');
