<?php

namespace App\Controller;

use App\Model\Article;
use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Controller;
use Home\CmsMini\View;

class BlogController extends Controller
{
    protected string $layout = 'base';

    public function index()
    {
        $this->view->setMeta('title', 'read our blog');
        $this->view->setMeta('header', 'read our blog');
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('blog/index', ['page' => new Pagination(Article::class, 3)]);
    }

    public function show(Article $article)
    {
        $this->view->setMeta('title', $article->getCategory()->title);
        $this->view->setMeta('title', $article->title);
        $this->view->setMeta('header', $article->title);
        $this->view->setMeta('description', $article->excerpt);
        $this->view->render('blog/show', compact('article'));
    }

    public function category(Category $category)
    {
        $this->view->setMeta('title', $category->title);
        $this->view->setMeta('header', $category->title);
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('blog/category', ['articles' => $category->getArticles()]);
    }
}
