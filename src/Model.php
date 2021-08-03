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
        $model = static::findOne($id);

        if (! $model instanceof Model) {
            throw new \Exception('Page not found');
        }

        return $model;
    }

    public static function find(string $field, string $value)
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
        // $query = Db::query(
        //     QueryBuilder::select()
        //         ->from(static::getTableName())
        //         ->where($field)
        //         ->sql()
        // );
        // $query->setParam($field, $value);
        // return $query->execute()->single(static::class);
        return static::find($field, $value)->single(static::class);
    }

    public static function findAll(string $field, string $value)
    {
        // $query = Db::query(
        //     QueryBuilder::select()
        //         ->from(static::getTableName())
        //         ->where($field)
        //         ->sql()
        // );
        // $query->setParam($field, $value);
        // return $query->execute()->list(static::class);
        return static::find($field, $value)->list(static::class);
    }

    public function isNew(): bool
    {
        return !isset($this->id);
    }

    public function create(): int
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

        return $result->rowCount();
    }

    public function save(): bool
    {

        if ($this->isNew()) {
            return $this->create();
        } else {
            return $this->update();
        }


        if (isset($this->id)) {
            $sets = [];
            $data = [':id' => $this->id];
            foreach ($this->fillable as $value) {
                $sets[] = $value . ' = :' . $value;
                $data[':' . $value] = $this->$value;
            }

            $sql = 'UPDATE ' . static::getTableName()
                . ' SET ' . implode(',', $sets)
                . ' WHERE id=:id';

            $result = $query->execute($sql, $data);
        } else {
            $binds = [];
            $data = [];
            foreach ($this->fillable as $value) {
                $columns[] = $value;
                $binds[] = ':' . $value;
                $data[':' . $value] = $this->$value;
            }
            
            
            $sql = 'INSERT INTO ' . static::getTableName() . ' ('
                . implode(',', $columns) . ') VALUES ('
                . implode(',', $binds)  . ')';

        }

        return $result;
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