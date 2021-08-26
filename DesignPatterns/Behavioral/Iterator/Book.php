<?php

namespace DesignPatterns\Behavioral\Iterator;

class Book
{
    public function __construct(
        private string $title,
        private string $author,
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getAuthorAndTitle(): string
    {
        return $this->getTitle() . ' by ' . $this->getAuthor();
    }
}