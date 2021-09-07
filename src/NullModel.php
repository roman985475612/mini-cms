<?php

namespace Home\CmsMini;

class NullModel extends Model
{
    public function isEmpty(): bool
    {
        return true;
    }
}