<?php

namespace Home\CmsMini;

class QueryBuilder
{
    protected \stdClass $query;

    public function __construct()
    {
        $this->query = new \stdClass;
    }

    public static function select(array $fields = ['*']): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'SELECT ' . implode(',', $fields) . "\n";
        return $queryBuilder;
    }

    public static function insert(string $tableName): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'INSERT INTO ' . $tableName . " \n";
        return $queryBuilder;
    }

    public static function update(string $tableName): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'UPDATE ' . $tableName . " \n";
        return $queryBuilder;
    }

    public static function delete(): QueryBuilder
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->query->base = 'DELETE ';
        return $queryBuilder;
    }

    public function from(string $tableName): QueryBuilder
    {
        $this->query->base .= "FROM " . $tableName . "\n";
        return $this;
    }

    public function columns(array $columns): QueryBuilder
    {
        $this->query->columns = $columns;
        $this->query->binds = array_map(fn($column) => ':' . $column, $columns);

        return $this;
    }

    public function set(string $field): QueryBuilder
    {
        $this->query->set[] = $field . ' = ' . ':' . $field;
    }

    public function where(string $field, string $operator = ''): QueryBuilder
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

    public function limit(int $start, int $offset): QueryBuilder
    {
        $this->query->limit = ' LIMIT ' . $start . ', ' . $offset;
        return $this;
    }

    public function order(string $field, bool $desc = true): QueryBuilder
    {
        $this->query->order = ' ORDER BY ' . $field . ($desc ? ' DESC' : ' ASC');
        return $this;
    }

    public function sql(): string
    {
        $sql = '';
        $sql .= $this->query->base;

        if (!empty($this->query->where)) {
            $sql .= 'WHERE ' . implode(' AND ', $this->query->where)  . "\n"; 
        }

        if (!empty($this->query->limit)) {
            $sql .= $this->query->limit . "\n";
        }

        if (!empty($this->query->order)) {
            $sql .= $this->query->order . "\n";
        }

        if (!empty($this->query->set)) {
            $sql .= 'SET ' . implode(' , ', $this->query->where)  . "\n"; 
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