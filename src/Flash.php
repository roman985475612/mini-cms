<?php

namespace Home\CmsMini;

class Flash
{
    const SUCCESS = 'success';
    
    const ERROR = 'danger';

    protected static function add(string $status, string $text)
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        $msg = new \stdClass;
        $msg->status = $status;
        $msg->text = $text;

        $_SESSION['flash'][] = $msg;
    }

    public static function addSuccess(string $msg)
    {
        self::add(self::SUCCESS, $msg);
    }

    public static function addError(string $msg)
    {
        self::add(self::ERROR, $msg);
    }

    public static function show()
    {
        if (!isset($_SESSION['flash']) || empty($_SESSION['flash'])) {
            return '';
        }

        self::render($_SESSION['flash']);
        
        $_SESSION['flash'] = [];
    }

    public static function render(array $messages)
    {
        ?>
        <div class="container">
            <?php foreach ($messages as $msg): ?>
                <div class="alert alert-<?= $msg->status ?> alert-dismissible fade show my-3" role="alert">
                    <strong><?= ucfirst($msg->status) ?>!</strong> <?= $msg->text ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>                
            <?php endforeach ?>
        </div>
        <?php
    }
}