<?php

namespace Tests;

use DesignPatterns\Structural\Flyweight\TextFactory;
use PHPUnit\Framework\TestCase;

class FlyweightTest extends TestCase
{
    private array $characters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k',
        'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];

    private array $fonts = ['Arial', 'Times New Roman', 'Verdana', 'Helvetica'];

    private static TextFactory $factory;
    
    public static function setUpBeforeClass(): void
    {
        self::$factory = new TextFactory;
    }

    public function testCharacters()
    {
        for ($i = 0; $i <= 10; $i++) {
            foreach ($this->characters as $char) {
                foreach ($this->fonts as $font) {
                    $flyweight = self::$factory->get($char);
                    $rendered = $flyweight->render($font);

                    $this->assertSame(sprintf('Character %s with font %s', $char, $font), $rendered);
                }
            }
        }
    }       

    public function testWord()
    {
        foreach ($this->fonts as $word) {
            $flyweight = self::$factory->get($word);
            $rendered = $flyweight->render('foobar');

            $this->assertSame(sprintf('Word %s with font foobar', $word), $rendered);
        }
    }

    public function testCount()
    {
        $this->assertCount(count($this->characters) + count($this->fonts), self::$factory);
    }
}