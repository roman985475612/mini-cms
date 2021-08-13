<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

abstract class Model
{
    public int $id;

    public string $created_at;

    public string $updated_at;

    protected static function getTableName()
    {
        $ref = new \ReflectionClass(static::class);
        return strtolower($ref->getShortName());
    }

    public static function __callStatic($name, $arguments)
    {
        switch ($name) {
            case 'count':
                $query = Db::query(
                    QueryBuilder::select(['count(*) AS count'])
                        ->from(static::getTableName())
                        ->sql()
                );
                return $query->execute()->fetch()['count'];
        
            case 'all':
                $query = Db::query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->order('updated_at')
                        ->sql()
                );
                return $query->execute()->list(static::class);
        
            case 'get':
                $query = Db::query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->where('id')
                        ->sql()
                );
                $query->setParam('id', $arguments[0]);
                return $query->execute()->single(static::class);

            case 'find':
                $query = Db::query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->where($arguments[0])
                        ->sql()
                );
                $query->setParam($arguments[0], $arguments[1]);
                return $query->execute();
        }
    }

    public static function getOr404(int $id)
    {
        $model = static::get($id);

        if (! $model instanceof Model) {
            throw new Http404Exception('Page not found');
        }

        return $model;
    }

    public static function findOne(string $field, string $value)
    {
        return static::find($field, $value)->single(static::class);
    }

    public static function findAll(string $field, string $value)
    {
        return static::find($field, $value)->list(static::class);
    }

    public function save(array $columns = []): bool
    {
        return $this->isNew() 
            ? $this->create(array_keys(get_object_vars($this))) 
            : $this->update($columns);
    }

    public function isNew(): bool
    {
        return !isset($this->id);
    }

    public function create(array $columns): bool
    {
        $query = Db::query(
            QueryBuilder::insert(static::getTableName())
                ->columns($columns)
                ->sql()
        );

        foreach ($columns as $name) {
            $query->setParam($name, $this->$name);
        }

        $result = $query->execute();
        
        $this->id = $query->lastId();

        return (bool) $result->rowCount();
    }

    public function update(array $columns): bool
    {
        $query = Db::query(
            QueryBuilder::update(static::getTableName())
                ->set($columns)
                ->where('id')
                ->sql()
        );
        
        foreach ($columns as $name) {
            $query->setParam($name, $this->$name);
        }
        $query->setParam('id', $this->id);
        return (bool) $query->execute()->rowCount();
    }

    public function delete(): int
    {
        $query = Db::query(
            QueryBuilder::delete()
                ->from(static::getTableName())
                ->where('id')
                ->sql()
        );

        $query->setParam('id', $this->id);
        
        return $query->execute()->rowCount();
    }
}