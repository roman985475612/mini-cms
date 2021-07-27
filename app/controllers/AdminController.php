<?php

namespace App\Controller;

use App\Model\Article;
use Home\CmsMini\Controller;

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
        $articles = Article::findAll();
        
        $this->header = 'dashboard';

        return $this->render('admin/index', compact('articles'));
    }
}