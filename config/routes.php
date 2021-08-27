<?php

use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\AuthController;
use App\Controller\AdminController;
use App\Controller\ArticleController;
use App\Controller\CategoryController;
use App\Controller\UserController;

return [
    'home' => [
        'pattern'    => '/',
        'controller' => HomeController::class,
        'action'     => 'index',
    ],
    'about' => [
        'pattern'    => '/about',
        'controller' => HomeController::class,
        'action'     => 'about',
    ],
    'services' => [
        'pattern'    => '/services',
        'controller' => HomeController::class,
        'action'     => 'services',
    ],
    'contact' => [
        'pattern'    => '/contact',
        'controller' => HomeController::class,
        'action'     => 'contact',
    ],
    'contact-store' => [
        'pattern'    => '/contact',
        'controller' => HomeController::class,
        'action'     => 'contactStore',
        'method'     => 'POST',
    ],
    'blog' => [
        'pattern'    => '/blog',
        'controller' => BlogController::class,
        'action'     => 'index',
    ],
    'blog-show' => [
        'pattern'    => '/blog/<id>',
        'controller' => BlogController::class,
        'action'     => 'show',
    ],
    'blog-by-category' => [
        'pattern'    => '/category/<id>',
        'controller' => BlogController::class,
        'action'     => 'category',
    ],

    'signup' => [
        'pattern'    => '/signup',
        'controller' => AuthController::class,
        'action'     => 'signup',
    ],
    'signin' => [
        'pattern'    => '/signin',
        'controller' => AuthController::class,
        'action'     => 'signin',
    ],
    'logout' => [
        'pattern'    => '/logout',
        'controller' => AuthController::class,
        'action'     => 'logout',
    ],
    'register' => [
        'pattern'    => '/register',
        'controller' => AuthController::class,
        'action'     => 'register',
        'method'     => 'POST',
    ],
    'login' => [
        'pattern'    => '/login',
        'controller' => AuthController::class,
        'action'     => 'login',
        'method'     => 'POST',
    ],
    'admin' => [
        'pattern'    => '/admin',
        'controller' => AdminController::class,
    ],
    'articles' => [
        'pattern'    => '/admin/articles',
        'controller' => ArticleController::class,
    ],
    'article-create' => [
        'pattern'    => '/admin/articles/create',
        'controller' => ArticleController::class,
        'action'     => 'create',
    ],
    'article-store' => [
        'pattern'    => '/admin/articles/store',
        'controller' => ArticleController::class,
        'action'     => 'store',
        'method'     => 'POST',

    ],
    'article-edit' => [
        'pattern'    => '/admin/articles/<id>/edit',
        'controller' => ArticleController::class,
        'action'     => 'edit',
    ],
    'article-update' => [
        'pattern'    => '/admin/articles/<id>/update',
        'controller' => ArticleController::class,
        'action'     => 'update',
        'method'     => 'POST',
    ],
    'article-delete' => [
        'pattern'    => '/admin/articles/<id>/delete',
        'controller' => ArticleController::class,
        'action'     => 'delete',
    ],
    'categories' => [
        'pattern'    => '/admin/categories',
        'controller' => CategoryController::class,
    ],
    'category-create' => [
        'pattern'    => '/admin/categories/create',
        'controller' => CategoryController::class,
        'action'     => 'create',
    ],
    'category-store' => [
        'pattern'    => '/admin/categories/store',
        'controller' => CategoryController::class,
        'action'     => 'store',
        'method'     => 'POST',
    ],
    'category-edit' => [
        'pattern'    => '/admin/categories/<id>/edit',
        'controller' => CategoryController::class,
        'action'     => 'edit',
    ],
    'category-update' => [
        'pattern'    => '/admin/categories/<id>/update',
        'controller' => CategoryController::class,
        'action'     => 'update',
        'method'     => 'POST',
    ],
    'category-delete' => [
        'pattern'    => '/admin/categories/<id>/delete',
        'controller' => CategoryController::class,
        'action'     => 'delete',
    ],
    'users' => [
        'pattern'    => '/admin/users',
        'controller' => UserController::class,
    ],
];
