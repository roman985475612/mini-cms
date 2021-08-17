<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

use DesignPatterns\Structural\Composite\Form;
use DesignPatterns\Structural\Composite\InputElement;
use DesignPatterns\Structural\Composite\LabelElement;

class CompositeTest extends TestCase
{
    public function testRender()
    {
        $form = new Form(['id' => 'form', 'class' => 'form', 'method' => 'GET', 'action' => '']);
        $form->addElement(new LabelElement('username', ['for' => 'username']));
        $form->addElement(new InputElement(['id' => 'username', 'type' => 'text', 'placeholder' => 'Username']));

        $this->assertSame(
            '<form id="form" class="form" method="GET" action=""><label for="username">Username</label><input id="username" type="text" placeholder="Username" /></form>',
            $form->render()
        );
    }
}