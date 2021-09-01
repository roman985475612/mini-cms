<?php

use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\Admin\AuthController;
use App\Controller\Admin\AdminController;
use App\Controller\Admin\PostController;
use App\Controller\Admin\CategoryController;
use App\Controller\Admin\UserController;

$main = [
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
    'users' => [
        'pattern'    => '/admin/users',
        'controller' => UserController::class,
    ],
];

$admin = function() {
    return [
        'admin' => [
            'pattern'    => '/admin',
            'controller' => AdminController::class,
        ],
        'profile' => [
            'pattern'    => '/profile',
            'controller' => AdminController::class,
            'action'     => 'profile',
        ],
        'profile-update' => [
            'pattern'    => '/profile/update',
            'controller' => AdminController::class,
            'action'     => 'update',
        ],
        'profile-delete' => [
            'pattern'    => '/profile/delete',
            'controller' => AdminController::class,
            'action'     => 'delete',
        ],
        'settings' => [
            'pattern'    => '/settings',
            'controller' => AdminController::class,
            'action'     => 'settings',
        ],
    ];
};

$home = function() {
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
        'subscribe' => [
            'pattern'    => '/subscribe',
            'controller' => HomeController::class,
            'action'     => 'subscribe',
            'method'     => 'POST',
        ],
    ];
};

$post = function() {
    $routes = [
        'posts'       => ['pattern' => '/admin/posts'],
        'post-create' => ['pattern' => '/admin/posts/create'     , 'action' => 'create'],
        'post-store'  => ['pattern' => '/admin/posts/store'      , 'action' => 'store' , 'method' => 'POST'],
        'post-edit'   => ['pattern' => '/admin/posts/<id>/edit'  , 'action' => 'edit'],
        'post-update' => ['pattern' => '/admin/posts/<id>/update', 'action' => 'update', 'method' => 'POST'],
        'post-delete' => ['pattern' => '/admin/posts/<id>/delete', 'action' => 'delete'],
        'post-table'  => ['pattern' => '/admin/posts/table'      , 'action' => 'table'],
    ];

    $routes = array_map(function ($route) {
        $route['controller'] = PostController::class;
        return $route;
    }, $routes);

    return $routes;
};

$category = function() {
    return [
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
        'category-table' => [
            'pattern'    => '/admin/categories/table',
            'controller' => CategoryController::class,
            'action'     => 'table',
        ],
        'categoryUploadForm' => [
            'pattern'    => '/admin/categories/upload-form',
            'controller' => CategoryController::class,
            'action'     => 'uploadForm',
        ],
        'categoryUpload' => [
            'pattern'    => '/admin/categories/upload',
            'controller' => CategoryController::class,
            'action'     => 'upload',
            'method'     => 'POST',
        ],
    ];
};

$routes = array_merge(
    $main,
    $home(),
    $post(),
    $category(),
    $admin(),
);

$routes = array_map(function ($route) {
    $route['method'] ??= 'GET';
    $route['action'] ??= 'index';
    return $route;
}, $routes);

return $routes;
