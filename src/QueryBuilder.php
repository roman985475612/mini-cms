<?php

namespace Home\CmsMini;

use stdClass;

class QueryBuilder
{
    protected stdClass $query;

    public function __construct()
    {
        $this->query = new stdClass;
    }

    public static function select(array $fields = ['*']): self
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'SELECT ' . implode(',', $fields) . "\n";
        return $queryBuilder;
    }

    public static function insert(string $tableName): self
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'INSERT INTO ' . $tableName . " \n";
        return $queryBuilder;
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

    public function columns(array $columns): self
    {
        $this->query->columns = $columns;
        $this->query->binds = array_map(fn($column) => ':' . $column, $columns);
        return $this;
    }

    public function set(array $columns): self
    {
        $this->query->set = array_map(fn($column) => $column . ' = ' . ':' . $column, $columns);
        return $this;
    }

    public function where(string $field, string $operator = ''): self
    {
        switch (func_num_args()) {
            case (1): 
                $this->query->where[] = $field . ' = ' . ':' . $field; 
                break;
            case (2): 
                $this->query->where[] = $field . ' ' . $operator . ' :' . $field; 
                break;
        }
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