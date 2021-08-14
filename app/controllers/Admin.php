<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;

class Admin extends Controller
{
    protected string $layout = 'secondary';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return $this->redirect(Auth::LOGIN_URL);
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

    public function logout()
    {
        Auth::logout();
    }
}