<?php

use Home\CmsMini\Auth;

return [
    [
        'title'     => 'home',
        'urlName'   => 'home'
    ],
    [
        'title'     => 'about us',
        'urlName'   => 'about'
    ],
    [
        'title'     => 'services',
        'urlName'   => 'services'
    ],
    [
        'title'     => 'blog',
        'urlName'   => 'blog'
    ],
    [
        'title'     => 'contact',
        'urlName'   => 'contact'
    ],
    [
        'title'     => 'signup',
        'urlName'   => 'signup',
        'role'      => [Auth::class, 'isGuest'],
    ],
    [
        'title'     => 'signin',
        'urlName'   => 'signin',
        'role'      => [Auth::class, 'isGuest'],
    ],
    [
        'title'     => 'account',
        'urlName'   => 'admin',
        'role'      => [Auth::class, 'isLoggedIn'],
    ],
    [
        'title'     => 'logout',
        'urlName'   => 'logout',
        'role'      => [Auth::class, 'isLoggedIn'],
    ],
];
