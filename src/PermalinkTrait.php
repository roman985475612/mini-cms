<?php

namespace Home\CmsMini;

trait PermalinkTrait
{
    public function getModelName()
    {
        $ref = new \ReflectionClass(static::class);
        return strtolower($ref->getShortName()); 
    }

    public function getPermalink()
    {
        return '/' . $this->getModelName() . '/' . $this->id;
    }
}