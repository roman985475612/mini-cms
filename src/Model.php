<?php

namespace Home\CmsMini;

abstract class Model
{
    protected int $id;

    protected string $created_at;

    protected string $updated_at;

    public static function count()
    {
        $query = Db::query(
            QueryBuilder::select(['count(*) AS count'])
                ->from(static::getTableName())
                ->sql()
        );
        return $query->execute()->fetch()['count'];
    }

    public static function all()
    {
        $query = Db::query(
            QueryBuilder::select()
                ->from(static::getTableName())
                ->order('updated_at')
                ->sql()
        );
        return $query->execute()->list(static::class);
    }

    public static function get(int $id)
    {
        $query = Db::query(
            QueryBuilder::select()
                ->from(static::getTableName())
                ->where('id')
                ->sql()
        );
        $query->setParam('id', $id);
        return $query->execute()->single(static::class);
    }

    public static function getOr404(int $id)
    {
        $model = static::get($id);

        if (! $model instanceof Model) {
            throw new \Exception('Page not found');
        }

        return $model;
    }

    protected static function find(string $field, string $value)
    {
        $query = Db::query(
            QueryBuilder::select()
                ->from(static::getTableName())
                ->where($field)
                ->sql()
        );
        $query->setParam($field, $value);
        return $query->execute();
    }

    public static function findOne(string $field, string $value)
    {
        return static::find($field, $value)->single(static::class);
    }

    public static function findAll(string $field, string $value)
    {
        return static::find($field, $value)->list(static::class);
    }

    public function save(): bool
    {
        return $this->isNew() ? $this->create() : $this->update();
    }

    public function isNew(): bool
    {
        return !isset($this->id);
    }

    public function create(): bool
    {
        $properties = get_object_vars($this);
        
        $query = Db::query(
            QueryBuilder::insert(static::getTableName())
                ->columns(array_keys($properties))
                ->sql()
        );

        foreach ($properties as $name => $value) {
            $query->setParam($name, $value);
        }

        $result = $query->execute();
        
        $this->id = $query->lastId();

        return (bool) $result->rowCount();
    }

    public function update(): bool
    {
        $properties = get_object_vars($this);
        
        $query = Db::query(
            QueryBuilder::update(static::getTableName())
                ->set(array_keys($properties))
                ->sql()
        );

        foreach ($properties as $name => $value) {
            $query->setParam($name, $value);
        }

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