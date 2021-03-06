<?php

use Home\CmsMini\Auth;
use App\Controller\HomeController;
use App\Controller\BlogController;
use App\Controller\Admin\AuthController;
use App\Controller\Admin\AdminController;
use App\Controller\Admin\PostController;
use App\Controller\Admin\CategoryController;
use App\Controller\Admin\UserController;

$blog = function () {
    return [
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
    ];
};

$auth = function () {
    return [
        'signup' => [
            'pattern'    => '/auth/signup',
            'controller' => AuthController::class,
            'action'     => 'signup',
        ],
        'signin' => [
            'pattern'    => '/auth/signin',
            'controller' => AuthController::class,
            'action'     => 'signin',
        ],
        'logout' => [
            'pattern'    => '/auth/logout',
            'controller' => AuthController::class,
            'action'     => 'logout',
        ],
        'register' => [
            'pattern'    => '/auth/register',
            'controller' => AuthController::class,
            'action'     => 'register',
            'method'     => 'POST',
        ],
        'confirm' => [
            'pattern'    => '/auth/confirm',
            'controller' => AuthController::class,
            'action'     => 'confirm',
        ],
        'forgot' => [
            'pattern'    => '/auth/forgot',
            'controller' => AuthController::class,
            'action'     => 'forgot',
        ],
        'recovery' => [
            'pattern'    => '/auth/recovery',
            'controller' => AuthController::class,
            'action'     => 'recovery',
            'method'     => 'POST',
        ],
        'login' => [
            'pattern'    => '/auth/login',
            'controller' => AuthController::class,
            'action'     => 'login',
            'method'     => 'POST',
        ],    
    ];
};

$admin = function() {
    $routes = [
        'admin' => [
            'pattern'    => '/admin',
        ],
        'profile' => [
            'pattern'    => '/profile',
            'action'     => 'profile',
        ],
        'profile-update' => [
            'pattern'    => '/profile/update',
            'action'     => 'update',
            'method'     => 'POST',
        ],
        'profile-delete' => [
            'pattern'    => '/profile/delete',
            'action'     => 'delete',
        ],
        'settings' => [
            'pattern'    => '/settings',
            'action'     => 'settings',
        ],
        'dashboard' => [
            'pattern'    => '/dashboard',
            'action'     => 'dashboard',
        ],
    ];

    $routes = array_map(function ($route) {
        $route['controller'] = AdminController::class;
        $route['permission'] = [Auth::class, 'isLoggedIn'];
        return $route;
    }, $routes);

    return $routes;
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
        'posts'          => ['pattern' => '/admin/posts'],
        'post-create'    => ['pattern' => '/admin/posts/create'     , 'action' => 'create'],
        'post-store'     => ['pattern' => '/admin/posts/store'      , 'action' => 'store' , 'method' => 'POST'],
        'post-edit'      => ['pattern' => '/admin/posts/<id>/edit'  , 'action' => 'edit'],
        'post-update'    => ['pattern' => '/admin/posts/<id>/update', 'action' => 'update', 'method' => 'POST'],
        'post-delete'    => ['pattern' => '/admin/posts/<id>/delete', 'action' => 'delete'],
        'post-table'     => ['pattern' => '/admin/posts/table'      , 'action' => 'table'],
        'postUploadForm' => ['pattern' => '/admin/posts/upload-form', 'action' => 'uploadForm'],
        'postUpload'     => ['pattern' => '/admin/posts/upload'     , 'action' => 'upload', 'method' => 'POST'],
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

$user = function () {
    $routes = [
        'users'       => ['pattern' => '/admin/users'],
        'user-create' => ['pattern' => '/admin/users/create'     , 'action' => 'create'],
        'user-store'  => ['pattern' => '/admin/users/store'      , 'action' => 'store' , 'method' => 'POST'],
        'user-edit'   => ['pattern' => '/admin/users/<id>/edit'  , 'action' => 'edit'],
        'user-update' => ['pattern' => '/admin/users/<id>/update', 'action' => 'update', 'method' => 'POST'],
        'user-delete' => ['pattern' => '/admin/users/<id>/delete', 'action' => 'delete'],
        'user-table'  => ['pattern' => '/admin/users/table'      , 'action' => 'table'],
        'user-upload-form' => ['pattern' => '/admin/users/upload-form', 'action' => 'uploadForm'],
    ];

    $routes = array_map(function ($route) {
        $route['controller'] = UserController::class;
        return $route;
    }, $routes);

    return $routes;    
};

$routes = array_merge(
    $home(),
    $blog(),
    $auth(),
    $admin(),
    $post(),
    $category(),
    $user(),
);

$routes = array_map(function ($route) {
    $route['method'] ??= 'GET';
    $route['action'] ??= 'index';
    $route['permission'] ??= fn() => true;
    return $route;
}, $routes);

return $routes;
