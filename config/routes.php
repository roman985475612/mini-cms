<?php

use Home\CmsMini\Router;

Router::get('', \App\Controller\Home::class);
Router::get('/patterns/composite', \App\Controller\Patterns::class, 'composite');
