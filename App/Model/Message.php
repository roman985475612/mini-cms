<?php

namespace App\Model;

use Home\CmsMini\Model;

class Message extends Model
{
    protected array $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'body',
    ];
}
