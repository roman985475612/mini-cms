<?php

return [
    [
        'title'     => 'dashboard',
        'urlName'   => 'admin',
        'role'      => 'isLoggedIn'
    ],
    [
        'title'     => 'posts',
        'urlName'   => 'posts',
        'role'      => 'isAdmin'
    ],
    [
        'title'     => 'categories',
        'urlName'   => 'categories',
        'role'      => 'isAdmin'
    ],
    [
        'title'     => 'users',
        'urlName'   => 'users',
        'role'      => 'isAdmin'
    ],
];