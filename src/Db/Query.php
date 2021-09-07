<?php

namespace Home\CmsMini\Db;

use Home\CmsMini\Model;
use Home\CmsMini\NullModel;
use PDO;
use stdClass;

class Query
{
    private $sth;

    private $sql;

    private $className;

    private $params = [];

    private $result;

    public static function select(array $fields = ['*']): self
    {
        $query = new Query;
        $query->sql = new stdClass;
        $query->sql->base = 'SELECT ' . implode(',', $fields);
        return $query;
    }

    public static function insert(string $tableName, array $data): self
    {
        $keys = array_keys($data);
        
        $fields = implode(', ', $keys);
        
        $binds = array_map(function($key) {
            return ':' . $key;
        }, $keys);

        $binds = implode(', ', $binds);

        $query = new Query;
        $query->sql = new stdClass;
        $query->params = $data;
        $query->sql->base = "INSERT INTO {$tableName} ({$fields}) VALUES ({$binds})";

        return $query;
    }

    public static function update(string $tableName, array $data): self
    {
        $keys = array_keys($data);

        $set = array_map(function($key) {
            return "{$key}=:{$key}";
        }, $keys);

        $set = implode(', ', $set);

        $query = new Query;
        $query->params = $data;
        $query->sql = new stdClass;
        $query->sql->base = "UPDATE {$tableName} SET {$set}";
        return $query;
    }

    public static function delete(): self
    {
        $query = new Query;
        $query->sql = new stdClass;
        $query->sql->base = "DELETE" ;
        return $query;
    }

    public function for(string $className): self
    {
        $this->className = $className;
        return $this;
    }

    public function execute(): self
    {
        $dbh = Connection::get();
        $this->sth = $dbh->prepare($this->text());
        $this->result = $this->sth->execute($this->params);
        return $this;
    }
    
    public function lastId(): int
    {
        return Connection::get()->lastInsertId();
    }

    public function result(): bool
    {
        return $this->result;
    }

    public function one(): Model
    {
        $this->limit(1);
        $this->execute();
        $obj = $this->sth->fetchObject($this->className);

        return $obj ?: new NullModel;
    }

    public function all(): array
    {
        $this->execute();
        return $this->sth->fetchAll(PDO::FETCH_CLASS, $this->className);
    }

    public function column(): mixed
    {
        $this->execute();
        return $this->sth->fetchColumn();
    }

    public function count(): int
    {
        return count($this->all());
    }

    public function from(string $tableName): self
    {
        $this->sql->from = "FROM {$tableName}";
        return $this;
    }

    public function where($var1, $var2 = null, $var3 = null): self
    {
        switch (func_num_args()) {
            case 1:
                $this->sql->where = $var1;
                $this->params = $var1;
                break;

            case 2:
                $this->sql->where = "WHERE {$var1}=:{$var1}";
                $this->params[$var1] = $var2;
                break;

            case 3:
                $this->sql->where = "WHERE {$var1} {$var3} :{$var1}";
                $this->params[$var1] = $var2;
                break;
        }

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->sql->limit = "LIMIT {$limit}";
        return $this;
    }

    public function offset(int $offset = 0): self
    {
        $this->sql->offset = "OFFSET {$offset}";
        return $this;
    }

    public function orderBy(string $field, bool $asc = true): self
    {
        $this->sql->orderBy = "ORDER BY {$field} ". ($asc ? 'ASC' : 'DESC');
        return $this;
    }

    public function text(): string
    {
        $text = $this->sql->base . PHP_EOL;

        if (!empty($this->sql->from)) {
            $text .= $this->sql->from . PHP_EOL;
        }

        if (!empty($this->sql->where)) {
            $text .= $this->sql->where . PHP_EOL;
        }

        if (!empty($this->sql->orderBy)) {
            $text .= $this->sql->orderBy . PHP_EOL;
        }

        if (!empty($this->sql->limit)) {
            $text .= $this->sql->limit . PHP_EOL;

            if (!empty($this->sql->offset)) {
                $text .= $this->sql->offset . PHP_EOL;
            }    
        }

        return $text . ';' . PHP_EOL;
    }
}