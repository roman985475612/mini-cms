<?php

use Home\CmsMini\Auth;

return [
    [
        'title'     => 'dashboard',
        'urlName'   => 'admin',
        'role'      => [Auth::class, 'isLoggedIn']
    ],
    [
        'title'     => 'posts',
        'urlName'   => 'posts',
        'role'      => [Auth::class, 'isAdmin'],
    ],
    [
        'title'     => 'categories',
        'urlName'   => 'categories',
        'role'      => [Auth::class, 'isAdmin'],
    ],
    [
        'title'     => 'users',
        'urlName'   => 'users',
        'role'      => [Auth::class, 'isAdmin'],
    ],
];