<?php

namespace App\Controller;

use Home\CmsMini\Controller;
use DesignPatterns\Structural\Adapter\{PaperBook, EBookAdapter, Kindle};
use DesignPatterns\Structural\Composite\Form;
use DesignPatterns\Structural\Composite\InputElement;
use DesignPatterns\Structural\Composite\LabelElement;

class Patterns extends Controller
{
    public function composite()
    {
        $form = new Form(['id' => 'form', 'class' => 'form', 'method' => 'GET', 'action' => '']);
        $form->addElement(new LabelElement('username', ['for' => 'username']));
        $form->addElement(new InputElement(['name' => 'username', 'id' => 'username', 'type' => 'text', 'placeholder' => 'Username']));
        echo $form->render();
    }

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