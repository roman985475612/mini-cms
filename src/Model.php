<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;

abstract class Model
{
    use PermalinkTrait;
    
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
                $db = App::$db->query(
                    QueryBuilder::select(['count(*) AS count'])
                        ->from(static::getTableName())
                        ->sql()
                );
                return $db->execute()->fetch()['count'];
        
            case 'all':
                $db = App::$db->query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->order('updated_at')
                        ->sql()
                );
                return $db->execute()->list(static::class);
        
            case 'get':
                $db = App::$db->query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->where('id')
                        ->sql()
                );
                $db->setParam('id', $arguments[0]);
                return $db->execute()->single(static::class);

            case 'find':
                $db = App::$db->query(
                    QueryBuilder::select()
                        ->from(static::getTableName())
                        ->where($arguments[0])
                        ->sql()
                );
                $db->setParam($arguments[0], $arguments[1]);
                return $db->execute();
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

    public function fill(array $data)
    {
        foreach ($data as $field => $datum) {
            $this->$field = $datum;
        }
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
        $db = App::$db->query(
            QueryBuilder::insert(static::getTableName())
                ->columns($columns)
                ->sql()
        );

        foreach ($columns as $name) {
            $db->setParam($name, $this->$name);
        }

        $result = $db->execute();
        
        $this->id = $db->lastId();

        return (bool) $result->rowCount();
    }

    public function update(array $columns): bool
    {
        $db = App::$db->query(
            QueryBuilder::update(static::getTableName())
                ->set($columns)
                ->where('id')
                ->sql()
        );
        
        foreach ($columns as $name) {
            $db->setParam($name, $this->$name);
        }
        $db->setParam('id', $this->id);
        return (bool) $db->execute()->rowCount();
    }

    public function delete(): int
    {
        $db = App::$db->query(
            QueryBuilder::delete()
                ->from(static::getTableName())
                ->where('id')
                ->sql()
        );

        $db->setParam('id', $this->id);
        
        return $db->execute()->rowCount();
    }
}