<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Model\User;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;

class AdminController extends Controller
{
    protected string $layout = 'layouts/secondary';

    protected function access(): bool
    {
        return Auth::isLoggedIn();
    }
    
    protected function accessDeny()
    {
        return $this->redirect(Auth::LOGIN_URL);
    }

    protected function setTitle()
    {
        parent::setTitle();
        $this->title = 'Admin' . ' | ' . $this->title;
    }

    public function actionIndex()
    {
        $counts['article'] = Article::count();
        $counts['category'] = Category::count();
        $counts['user'] = User::count();
        $articles = Article::all();
        
        $this->header = 'dashboard';

        return $this->render('admin/index', compact('articles', 'counts'));
    }

    public function actionLogout()
    {
        Auth::logout();
    }
}