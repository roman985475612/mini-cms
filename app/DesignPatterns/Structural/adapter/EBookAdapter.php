<?php

namespace DesignPatterns\Structural\Adapter;

class EBookAdapter implements BookInterface
{
    public function __construct(protected EBookInterface $eBook)
    {
    }

    public function turnPage(): void
    {
        $this->eBook->pressNext();
    }

    public function open(): void
    {
        $this->eBook->unlock();
    }

    public function getPage(): int
    {
        return $this->eBook->getPage()[0];
    }
}
