<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Auth;
use Home\CmsMini\Controller;
use Home\CmsMini\Flash;

class AdminController extends Controller
{
    protected string $layout = 'layouts/secondary';

    public function __construct()
    {
        parent::__construct();

        $this->title = 'Admin';
    }

    public function actionIndex()
    {
        Auth::loginRequired('admin');

        $counts['article'] = Article::count();
        $counts['category'] = Category::count();
        $articles = Article::all();
        
        $this->header = 'dashboard';

        return $this->render('admin/index', compact('articles', 'counts'));
    }

    public function actionLogin()
    {
        if (Auth::isLoggedIn()) {
            $this->redirect('admin');
        }

        $this->layout = 'layouts/simple';
        $this->header = 'login';

        return $this->render('admin/user/login');
    }

    public function actionLogout()
    {
        Auth::logout();
    }
}