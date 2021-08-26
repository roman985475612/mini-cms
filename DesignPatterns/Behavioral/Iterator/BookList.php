<?php

namespace DesignPatterns\Behavioral\Iterator;

use Countable;
use Iterator;

class BookList implements Countable, Iterator
{
    private array $books = [];

    private int $currentIndex = 0;

    public function add(Book $book)
    {
        $this->books[] = $book;
    }

    public function remove(Book $bookToRemove)
    {
        $books = array_filter($this->books, function ($book) use ($bookToRemove) {
            return $book->getAuthorAndTitle() !== $bookToRemove->getAuthorAndTitle();
        });

        $this->books = array_values($books);
    }

    public function count(): int
    {
        return count($this->books);
    }

    public function current(): Book
    {
        return $this->books[$this->currentIndex];
    }

    public function key(): int
    {
        return $this->currentIndex;
    }

    public function next()
    {
        $this->currentIndex++;
    }

    public function rewind()
    {
        $this->currentIndex = 0;
    }

    public function valid(): bool
    {
        return isset($this->books[$this->currentIndex]);
    }
}