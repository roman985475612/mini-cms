<?php

namespace App\Controller;

use App\Model\Article;
use Home\CmsMini\Controller;

class ArticleController extends Controller
{
    protected string $layout = 'layouts/secondary';
    
    public function actionIndex()
    {
        echo __METHOD__;
    }

    public function actionCreate()
    {
        echo __METHOD__;
    }

    public function actionUpdate(int $id)
    {
        $article = Article::findOne($id);
        
        $this->header = $article->title;

        return $this->render('admin/article/update', compact('article'));
    }

    public function actionDelete(int $id)
    {
        $article = Article::findOne($id);
        $article->delete();

        return $this->redirect('admin');
    }
}
