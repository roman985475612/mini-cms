<?php

namespace Home\CmsMini;

abstract class Model
{
    protected int $id;

    protected string $created_at;

    protected string $updated_at;

    public static function findAll()
    {
        $db = Db::instance();
        $db->query = 'SELECT * FROM ' . static::TABLE;
        $db->execute();
        return $db->select(static::class);
    }

    public static function findOne(int $id)
    {
        $db = Db::instance();
        $db->query = 'SELECT * FROM ' . static::TABLE . ' WHERE id=:id';
        $db->setParams(':id', $id);
        $db->execute();
        return $db->selectOne(static::class);
    }

    public static function findBy(string $name, string $value)
    {
        $db = Db::instance();
        $sql = 'select * from ' . static::TABLE . ' WHERE ' . $name . '=:' . $name ;
        $data = [":$name" => $value];
        $db->execute($sql, $data);
        return $db->fetch(static::class);
    }

    public static function create(array $data)
    {
        $model = new static;
        foreach ($model->fillable as $key => $value) {
            if (isset($data[$value])) {
                $model->$value = $data[$value];
            }
        }
        return $model;
    }

    public function save(): bool
    {
        $db = Db::instance();
        if (isset($this->id)) {
            $sets = [];
            $data = [':id' => $this->id];
            foreach ($this->fillable as $value) {
                $sets[] = $value . ' = :' . $value;
                $data[':' . $value] = $this->$value;
            }

            $sql = 'UPDATE ' . static::TABLE
                . ' SET ' . implode(',', $sets)
                . ' WHERE id=:id';

            $result = $db->execute($sql, $data);
        } else {
            $columns = [];
            $binds = [];
            $data = [];
            foreach ($this->fillable as $value) {
                $columns[] = $value;
                $binds[] = ':' . $value;
                $data[':' . $value] = $this->$value;
            }

            $sql = 'INSERT INTO ' . static::TABLE . ' ('
                . implode(',', $columns) . ') VALUES ('
                . implode(',', $binds)  . ')';

            $result = $db->execute($sql, $data);
            $this->id = $db->lastId();
        }

        return $result;
    }

    public function delete(): bool
    {
        $data = [':id' => $this->id];
        $sql = 'DELETE FROM ' . static::TABLE . ' WHERE id=:id';
        $db = Db::instance();
        return $db->execute($sql, $data);
    }
}