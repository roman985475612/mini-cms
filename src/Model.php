<?php

namespace Home\CmsMini;

use Home\CmsMini\Exception\Http404Exception;
use Home\CmsMini\Db\Query;

abstract class Model
{
    private array $updateFields = [];
    
    protected array $fields = [];

    public function __get(string $name)
    {
        return $this->fields[$name];
    }

    public function __set(string $name, mixed $value)
    {
        if (!(isset($this->$name) && $this->$name == $value)) {
            $this->addField($name);    
        }
        $this->fields[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->fields[$name]);
    }

    public function getDate()
    {
        return date('F j, Y', strtotime($this->updated_at));
    }

    protected function addField(string $name)
    {
        $this->updateFields[] = $name;
    }

    protected function getUpdateFields()
    {
        return array_unique($this->updateFields);
    }

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

    public static function get(string $id): static
    {
        return (new Query(App::$db))
            ->select()
            ->from(static::getTableName())
            ->where('id', $id)
            ->limit(1)
            ->one(static::class);
    }

    public static function limit(int $limit, int $offset)
    {
        $db = App::$db->query(
            QueryBuilder::select()
                ->from(static::getTableName())
                // ->order('updated_at')
                ->limit($limit)
                ->offset($offset)
                ->sql()
        );
        return $db->execute()->list(static::class);
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

    public static function create(array $data): bool
    {
        $object = new static;
        $object->fill($data);
        return $object->insert($object->getUpdateFields());
    }

    public function fill(array $data)
    {
        foreach ($data as $field => $datum) {
            $this->$field = $datum;
        }
    }

    public function save(): bool
    {
        return $this->isNew() 
            ? $this->insert($this->getUpdateFields())
            : $this->update($this->getUpdateFields());
    }

    protected function isNew(): bool
    {
        return !isset($this->id);
    }

    protected function insert(array $columns): bool
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

    protected function update(array $columns): bool
    {
        if (empty($columns)) {
            return false;
        }

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

    public function delete(): bool
    {
        $db = App::$db->query(
            QueryBuilder::delete()
                ->from(static::getTableName())
                ->where('id')
                ->sql()
        );

        $db->setParam('id', $this->id);
        
        return (bool) $db->execute()->rowCount();
    }
}