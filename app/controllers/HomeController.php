<?php

namespace App\Controller;

use App\Model\Category;
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
        $categores = Category::findAll();
        $title = 'Categories';
        
        $this->title = 'This is NEW title!';
        
        return $this->render('home/index', compact('title', 'categores'));
    }
}