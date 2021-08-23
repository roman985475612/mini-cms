<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;
use Home\CmsMini\Request;

class AdminController extends Controller
{
    protected string $layout = 'admin';

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
        $counts['article'] = Article::count();
        $counts['category'] = Category::count();
        $counts['user'] = User::count();
        $articles = Article::all();
        
        $this->header = 'dashboard';

        return $this->render('admin/index', compact('articles', 'counts'));
    }
}