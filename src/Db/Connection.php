<?php

namespace Home\CmsMini\Db;

use PDO;

class Connection
{
    private static $dbh;

    public static function init(
        string $dsn, 
        string $user, 
        string $pass
    )
    {
        self::$dbh = new PDO($dsn, $user, $pass);
    }

    public static function get(): PDO
    {
        return self::$dbh;
    }
}