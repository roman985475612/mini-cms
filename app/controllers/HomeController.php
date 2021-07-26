<?php

namespace App\Controller;

use App\Model\Article;
use Home\CmsMini\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->title = 'HOME';
        $this->keywords = 'home, sweet, home';
        $this->description = 'Home sweet home';
    }

    public function actionIndex()
    {
        $articles = Article::findAll();
        
        $this->title = 'read our blog';
        $this->description = 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Perspiciatis, nam.';
        
        return $this->render('home/index', compact('articles'));
    }
}