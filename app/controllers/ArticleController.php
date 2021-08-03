<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use Home\CmsMini\Controller;

class ArticleController extends Controller
{
    public function actionCategory(int $id)
    {
        $category = Category::findOneOr404($id);
        $articles = $category->articles();
        
        $this->title = $category->title;
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/index', compact('articles'));
    }
}
