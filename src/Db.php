<?php

namespace Home\CmsMini;

class Db
{
    protected static $instance = null;

    protected $dbh;

    protected $sth;

    protected $result;

    public static function instance(
        string $host, 
        string $name, 
        string $user, 
        string $pass, 
    )
    {
        if (is_null(static::$instance)) {
            static::$instance = new static($host, $name, $user, $pass);
        }
        return static::$instance;
    }

    public function __construct(
        string $host, 
        string $name, 
        string $user, 
        string $pass, 
    )
    {
        try {
            $this->dbh = new \PDO(
                'mysql:host=' . $host . ';dbname=' . $name,
                $user,
                $pass
            );    
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }
    }

    protected function __clone() {}

    // public static function query(string $query)
    // {
    //     static::$instance->sth = static::$instance->dbh->prepare($query);
    //     return static::$instance;
    // }

    public function query(string $query)
    {
        $this->sth = $this->dbh->prepare($query);
        return $this;
    }

    public function setParam(string $name, mixed $value): void
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