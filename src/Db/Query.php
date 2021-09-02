<?php

namespace Home\CmsMini\Db;

use Home\CmsMini\Db;
use Home\CmsMini\Model;
use stdClass;

class Query
{
    private $query;

    private $params = [];

    private $db;

    public function __construct(Db $db)
    {
        $this->db = $db;
        $this->query = new stdClass;
    }

    public function execute()
    {
        $this->db->query($this->sql());

        foreach ($this->params as $name => $value) {
            $this->db->setParam($name, $value);
        }

        return $this->db->execute();
    }

    public function count(): int
    {
        return $this->execute()->rowCount();
    }

    public function one(string $className): Model
    {
        return $this->execute()->single($className);
    }

    public function select(array $fields = ['*']): self
    {
        $this->query->base = 'SELECT ' . implode(',', $fields) . PHP_EOL;
        return $this;
    }

    public function insert(string $tableName, array $data): self
    {
        $this->query->base = "INSERT INTO {$tableName}"  . PHP_EOL;
        $this->columns(array_keys($data));
        $this->params = $data;

        return $this;
    }

    public static function update(string $tableName): self
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'UPDATE ' . $tableName . " \n";
        return $queryBuilder;
    }

    public static function delete(): self
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'DELETE ';
        return $queryBuilder;
    }

    public function from(string $tableName): self
    {
        $this->query->base .= "FROM " . $tableName . "\n";
        return $this;
    }

    private function columns(array $columns): self
    {
        $this->query->columns = $columns;
        $this->query->binds = array_map(function($column) {
            return ':' . $column;
        }, $columns);
        return $this;
    }

    public function set(array $columns): self
    {
        $this->query->set = array_map(function($column) {
            return $column . ' = ' . ':' . $column;
        }, $columns);

        return $this;
    }

    public function where(string $name, $value, ?string $operator = null): self
    {
//        $this->query->where[] = match (func_num_args()) {
//            2 => "{$name}=:{$name}",
//            3 => "{$name} {$operator} :{$name}",
//        };

        switch (func_num_args()) {
            case 2:
                $this->query->where[] = "{$name}=:{$name}";
                break;

            case 3:
                $this->query->where[] = "{$name} {$operator} :{$name}";
                break;
        }

        $this->params[$name] = $value;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->query->limit = ' LIMIT ' . $limit;
        return $this;
    }

    public function offset(int $offset = 0): self
    {
        $this->query->offset = ' OFFSET ' . $offset;
        return $this;
    }

    public function order(string $field, bool $desc = true): self
    {
        $this->query->order = ' ORDER BY ' . $field . ($desc ? ' DESC' : ' ASC');
        return $this;
    }

    public function sql(): string
    {
        $sql = '';
        $sql .= $this->query->base;

        if (!empty($this->query->set)) {
            $sql .= 'SET ' . implode(', ', $this->query->set)  . "\n"; 
        }

        if (!empty($this->query->where)) {
            $sql .= 'WHERE ' . implode(' AND ', $this->query->where)  . "\n"; 
        }

        if (!empty($this->query->order)) {
            $sql .= $this->query->order . "\n";
        }

        if (!empty($this->query->limit)) {
            $sql .= $this->query->limit . "\n";

            if (!empty($this->query->offset)) {
                $sql .= $this->query->offset . "\n";
            }    
        }

        if (!empty($this->query->columns)) {
            $sql .= '(' . implode(', ', $this->query->columns) . ')' . "\n";
        }

        if (!empty($this->query->binds)) {
            $sql .= 'VALUES (' . implode(', ', $this->query->binds)  . ')';
        }

        $sql .= ';';

        return $sql;
    }
}