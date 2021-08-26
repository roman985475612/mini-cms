<?php

namespace Tests;

use DesignPatterns\Behavioral\Iterator\Book;
use DesignPatterns\Behavioral\Iterator\BookList;
use PHPUnit\Framework\TestCase;

class IteratorTest extends TestCase
{
    public function testCanIterateOverBookList()
    {
        $bookList = new BookList;
        $bookList->add(new Book('Learning PHP Design Patterns', 'William Sanders'));
        $bookList->add(new Book('Professional Php Design Patterns', 'Aaron Saray'));
        $bookList->add(new Book('Clean Code', 'Robert C. Martin'));

        $books = array_map(function ($book) {
            return $book->getAuthorAndTitle();
        }, iterator_to_array($bookList));

        $this->assertSame(
            [
                'Learning PHP Design Patterns by William Sanders',
                'Professional Php Design Patterns by Aaron Saray',
                'Clean Code by Robert C. Martin',
            ],
            $books
        );
    }

    public function testCanIterateOverBookListAfterRemovingBook()
    {
        $book1 = new Book('Clean Code', 'Robert C. Martin');
        $book2 = new Book('Professional Php Design Patterns', 'Aaron Saray');

        $bookList = new BookList;
        $bookList->add($book1);
        $bookList->add($book2);
        $bookList->remove($book1);

        $books = array_map(function ($book) {
            return $book->getAuthorAndTitle();
        }, iterator_to_array($bookList));

        $this->assertSame(
            ['Professional Php Design Patterns by Aaron Saray'],
            $books
        );
    }

    public function testCanAddBookToList()
    {
        $book = new Book('Clean Code', 'Robert C. Martin');

        $bookList = new BookList;
        $bookList->add($book);

        $this->assertCount(1, $bookList);
    }

    public function testCanRemoveBookFromList()
    {
        $book = new Book('Clean Code', 'Robert C. Martin');

        $bookList = new BookList;
        $bookList->add($book);
        $bookList->remove($book);

        $this->assertCount(0, $bookList);
    }
}