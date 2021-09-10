<?php

namespace App\Widget;

use Home\CmsMini\App;
use Home\CmsMini\Db\Query;
use Home\CmsMini\View;
use stdClass;

class Pagination
{
    private int $totalCount;

    private int $countPages;

    private int $curPage;

    private int $start;

    public function __construct(
        private Query $query,
        private int $perPage = 9,
    )
    {
        $this->setTotalCount();
        $this->setCountPages();
        $this->setCurrentPage();
        $this->setStart();
    }

    private function setTotalCount(): void
    {
        $this->totalCount = $this->query->count();
    }

    private function fetchAll()
    {
        return $this->query            
            ->limit($this->perPage)
            ->offset($this->start)
            ->all();
    }

    public function render(string $template): void
    {
        if ($this->totalCount > $this->perPage) {
            (new View)->renderPart($template, ['page' => $this]);
        }
    }

    private function setCountPages()
    {
        $this->countPages = ceil($this->totalCount / $this->perPage) ?: 1;
    }

    private function setCurrentPage()
    {
        $page = App::request()->get('page');

        if (empty($page) || $page < 1) {
            $page = 1;
        }

        if ($page > $this->countPages) {
            $page = $this->countPages;
        }

        $this->curPage = $page; 
    }

    private function setStart()
    {
        $this->start = ($this->curPage - 1) * $this->perPage;
    }

    private function getUrl(int $page)
    {
        $url = App::request()->get();

        if ($page == 1) {
            unset($url['page']);
        } else {
            $url['page'] = $page;
        }
        
        unset($url['URI']);

        $query = [];
        foreach ($url as $key => $value) {
            $query[] = $key . '=' . $value;
        }
        
        $queryString = '/' . App::request()->get('URI');
        $queryString .= count($query) ? '?' : '';
        $queryString .= implode('&', $query);

        return $queryString; 
    }

    public function __get($name)
    {
        return match ($name) {
            'isPrev'=> $this->isPrev(),
            'isNext'=> $this->isNext(),
            'prev'  => $this->getPrev(),
            'next'  => $this->getNext(),
            'pages' => $this->getPages(),
            'objects' => $this->fetchAll(),
        };
    }

    private function isPrev()
    {
        return $this->curPage > 1;
    }

    private function isNext()
    {
        return $this->curPage < $this->countPages;
    }

    private function getPrev()
    {
        if ($this->isPrev()) {
            return $this->getUrl($this->curPage - 1);
        }
    }

    private function getNext()
    {
        if ($this->isNext()) {
            return $this->getUrl($this->curPage + 1);
        }
    }

    private function getPages()
    {
        $pages = [];

        for ($i = 1; $i <= $this->countPages; $i++) {
            $page = new stdClass;
            $page->href = $this->getUrl($i);
            $page->title = $i;
            $page->isCurrent = $i === $this->curPage;

            $pages[] = $page;
        }

        return $pages;
    }
}
