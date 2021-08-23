<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities;

use Home\CmsMini\Request;

abstract class Handler
{
    public function __construct(private ?self $successor = null) {}

    final public function handle(Request $request): ?string
    {
        $processed = $this->processing($request);

        if (is_null($processed) && !is_null($this->successor)) {
            $processed = $this->successor->handle($request);
        }

        return $processed;
    }

    abstract protected function processing(Request $request): ?string;
}