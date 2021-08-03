<?php

namespace Home\CmsMini;

class Db
{
    protected static $instance = null;

    protected $dbh;

    protected $sth;

    protected $result;

    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    protected function __construct()
    {
        $config = Config::instance()->config['db'];

        try {
            $this->dbh = new \PDO(
                'mysql:host=' . $config['host'] . ';dbname=' . $config['name'],
                $config['user'],
                $config['pass']
            );    
        } catch (PDOExecption $e) {
            echo $e->getMessage();
        }
    }

    protected function __clone() 
    {
    }

    public static function query(string $query)
    {
        $db = static::instance();
        $db->sth = $db->dbh->prepare($query);
        return $db;
    }

    public function setParam($name, $value)
    {
        switch ($value) {
            case is_bool($value): $type = \PDO::PARAM_BOOL; break;
            case is_int($value): $type = \PDO::PARAM_INT; break;
            default: $type = \PDO::PARAM_STR;
        }

        $this->sth->bindParam(':' . $name, $value, $type);
    }

    public function execute(): Db
    {
        $this->result = $this->sth->execute();
        return $this;
    }

    public function rowCount()
    {
        return $this->sth->rowCount();
    }

    public function list($className): array
    {
        return $this->sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function single($className)
    {
        return $this->sth->fetchObject($className);
    }

    public function fetch()
    {
        return $this->sth->fetch();
    }

    public function lastId(): int
    {
        return $this->dbh->lastInsertId();
    }
}