<?php

namespace App\Controller;

use App\Model\Post;
use App\Model\Category;
use App\Widget\Pagination;
use Home\CmsMini\Controller;

class BlogController extends Controller
{
    protected string $layout = 'base';

    public function index()
    {
        $this->view->setMeta('title', 'read our blog');
        $this->view->setMeta('header', 'read our blog');
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('blog/index', ['page' => new Pagination(Post::class, 3)]);
    }

    public function show(Post $post)
    {
        $this->view->setMeta('title', $post->getCategory());
        $this->view->setMeta('title', $post->title);
        $this->view->setMeta('header', $post->title);
        $this->view->setMeta('description', $post->getExcerpt());
        $this->view->render('blog/show', compact('post'));
    }

    public function category(Category $category)
    {
        $this->view->setMeta('title', $category->title);
        $this->view->setMeta('header', $category->title);
        $this->view->setMeta('description', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.');
        $this->view->render('blog/category', ['posts' => $category->getPosts()]);
    }
}
