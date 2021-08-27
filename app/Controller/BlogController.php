<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Controller;
use Home\CmsMini\View;

class BlogController extends Controller
{
    public function index()
    {
        $page = new Pagination(Article::class, 3);

        $view = new View;
        $view->title = 'read our blog';
        $view->header = 'read our blog';
        $view->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        $view->template = 'blog/index';
        $view->render(compact('page'));
    }

    public function show(Article $article)
    {
        $view = new View;
        $view->title = $article->getCategory()->title;
        $view->title = $article->title;
        $view->header = $article->title;
        $view->description = $article->excerpt;
        $view->template = 'blog/show';
        $view->render(compact('article'));
    }

    public function category(Category $category)
    {
        $view = new View;
        $view->title = $category->title;
        $view->header = $category->title;
        $view->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        $view->template = 'blog/category';
        $view->render(['articles' => $category->getArticles()]);
    }
}
