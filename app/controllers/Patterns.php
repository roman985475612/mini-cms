<?php

namespace App\Controller;

use Home\CmsMini\Controller;
use DesignPatterns\Structural\Adapter\{PaperBook, EBookAdapter, Kindle};

class Patterns extends Controller
{
    public function adapter()
    {
        $book = new PaperBook;
        $book->open();
        $book->turnPage();

        dd('Current page: ' . $book->getPage(), false);

        $book = new EBookAdapter(new Kindle);
        $book->open();
        $book->turnPage();

        dd('Current page: ' . $book->getPage(), false);
    }
}