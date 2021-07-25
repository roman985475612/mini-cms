<?php

namespace Home\CmsMini;

class Db
{
    protected static $instance = null;

    protected $dbh;

    protected $sth;

    public string $query;

    protected array $params = [];

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
        $this->dbh = new \PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['name'],
            $config['user'],
            $config['pass']
        );
    }

    protected function __clone() {}

    public function setParameter($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function execute(): bool
    {
        $this->sth = $this->dbh->prepare($this->query);
        return $this->sth->execute($this->params);
    }

    public function insert(string $tableName, array $data, bool $printSql = false)
    {
        $columns = [];
        $binds = [];
        $this->params = [];
        foreach ($data as $fieldName => $value) {
            $columns[] = $fieldName;
            $binds[] = ':' . $fieldName;
            $preparedData[':' . $fieldName] = $value;
        }

        $this->queery = "INSERT INTO {$tableName}\n\t("
            . implode(',', $columns) 
            . ")\n\tVALUES ("
            . implode(',', $binds)  
            . ")\n";

        if ($printSql) {
            echo $sql;
            exit;
        }  

        return $this->execute();
    }

    public function select($className)
    {
        return $this->sth->fetchAll(\PDO::FETCH_CLASS, $className);
    }

    public function selectOne($className)
    {
        return $this->sth->fetchObject($className);
    }

    public function lastId(): int
    {
        return $this->dbh->lastInsertId();
    }
}