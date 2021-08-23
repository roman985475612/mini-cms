<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;
use Home\CmsMini\Request;

class HttpInMemoryCacheHandler extends Handler
{
    public function __construct(
        private array $data,
        ?Handler $successor = null
    )
    {
        parent::__construct($successor);
    }

    protected function processing(Request $request): ?string
    {
        $key = sprintf(
            '%s?%s',
            $request::getPath(),
            $request::getQuery(),
        );

        if ($request->getMethod() == 'GET' && isset($this->data[$key])) {
            return $this->data[$key];
        }

        return null;
    }
}
