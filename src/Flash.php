<?php

namespace Home\CmsMini;

class Flash
{
    const SUCCESS = 'success';
    
    const ERROR = 'danger';

    protected static function add(string $status, string $msg)
    {
        if (!isset($_SESSION['flash'])) {
            $_SESSION['flash'] = [];
        }

        $_SESSION['flash'][$status] = $msg;
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
        <div class="container my-3">
            <?php foreach ($messages as $status => $msg): ?>
                <div class="alert alert-<?= $status ?> alert-dismissible fade show" role="alert">
                    <strong><?= ucfirst($status) ?>!</strong> <?= $msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>                
            <?php endforeach ?>
        </div>
        <?php
    }
}