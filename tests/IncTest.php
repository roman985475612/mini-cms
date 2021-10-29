<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;

class IncTest extends TestCase
{
    private $post;

    public function setUp(): void
    {
        $this->post = (new class {
            private int $id = 0;

            public function generateId(): int
            {
                return ++$this->id;
            }        
        });
    }

    public function testGenerateId()
    {
        $id = $this->post->generateId();
        $id = $this->post->generateId();
        $id = $this->post->generateId();

        $this->assertSame(3, $id);
    }
}

