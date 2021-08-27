<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;
use Home\CmsMini\View;

class AdminController extends Controller
{
    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return Request::redirect(Auth::LOGIN_URL);
    }

    public function index()
    {
        $view = new View;
        $view->title = 'dashboard';
        $view->header = 'dashboard';
        $view->layout = 'admin';
        $view->template = 'admin/index';
        $view->render([
            'articles' => Article::all(),
            'headerClass' => 'bg-primary',
            'counts'   => [
                'article'  => Article::count(),
                'category' => Category::count(),
                'user'     => User::count(),        
            ],
        ]);
    }
}