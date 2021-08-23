<?php

use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\ArticleController;
use App\Controller\CategoryController;
use App\Controller\UserController;

return [
    [
        'pattern'    => '/',
        'controller' => HomeController::class,
        'action'     => 'index',
        'name'       => 'home',
    ],
    [
        'pattern'    => '/about',
        'controller' => HomeController::class,
        'action'     => 'about',
        'name'       => 'about',
    ],
    [
        'pattern'    => '/services',
        'controller' => HomeController::class,
        'action'     => 'services',
        'name'       => 'services',
    ],
    [
        'pattern'    => '/contact',
        'controller' => HomeController::class,
        'action'     => 'contact',
        'name'       => 'contact',
    ],
    [
        'pattern'    => '/contact',
        'controller' => HomeController::class,
        'action'     => 'contactStore',
        'name'       => 'contact-store',
        'method'     => ['POST'],
    ],
    [
        'pattern'    => '/blog',
        'controller' => BlogController::class,
        'action'     => 'index',
        'name'       => 'blog',
    ],
    [
        'pattern'    => '/blog/<id>',
        'controller' => BlogController::class,
        'action'     => 'show',
        'name'       => 'blog-show',
    ],
    [
        'pattern'    => '/category/<id>',
        'controller' => BlogController::class,
        'action'     => 'category',
        'name'       => 'blog-by-category',
    ],

    [
        'pattern'    => '/signup',
        'controller' => AuthController::class,
        'action'     => 'signup',
        'name'       => 'signup',
    ],
    [
        'pattern'    => '/signin',
        'controller' => AuthController::class,
        'action'     => 'signin',
        'name'       => 'signin',
    ],
    [
        'pattern'    => '/logout',
        'controller' => AuthController::class,
        'action'     => 'logout',
        'name'       => 'logout',
    ],
    [
        'pattern'    => '/register',
        'controller' => AuthController::class,
        'action'     => 'register',
        'method'     => ['POST'],
        'name'       => 'register',
    ],
    [
        'pattern'    => '/login',
        'controller' => AuthController::class,
        'action'     => 'login',
        'method'     => ['POST'],
        'name'       => 'login',
    ],
    [
        'pattern'    => '/admin',
        'controller' => AdminController::class,
        'name'       => 'admin',
    ],
    [
        'pattern'    => '/admin/articles',
        'controller' => ArticleController::class,
        'name'       => 'articles',
    ],
    [
        'pattern'    => '/admin/articles/<id>/edit',
        'controller' => ArticleController::class,
        'name'       => 'article-edit',
    ],
    [
        'pattern'    => '/admin/categories',
        'controller' => CategoryController::class,
        'name'       => 'categories',
    ],
    [
        'pattern'    => '/admin/users',
        'controller' => UserController::class,
        'name'       => 'users',
    ],
];
