<?php

namespace Home\CmsMini;

use Exception;
use Home\CmsMini\Exception\Http404Exception;
use Home\CmsMini\Db\Query;

abstract class Model
{
    use CommonFieldAccessorsTrait;

    protected array $fields = [];

    protected bool $recordMode = false;

    protected array $changedFields = [];

    protected array $fillable = [];
    
    public function __get(string $name): ?string
    {
        return $this->fields[$name] ?? null;
    }

    public function __set(string $name, mixed $value)
    {
        if ($this->recordModeIsEnable()
            && $this->$name != $value) {
            $this->changedFields[$name] = $value;
        }
        $this->fields[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->fields[$name]);
    }

    public function recordModeIsEnable(): bool
    {
        return $this->recordMode;
    }

    public function recordModeEnable(): void
    {
        $this->recordMode = true;
    }

    public function recordModeDisable(): void
    {
        $this->recordMode = false;
    }

    public function isEmpty(): bool
    {
        return false;
    }

    protected static function tableName(): string
    {
        $ref = new \ReflectionClass(static::class);
        return strtolower($ref->getShortName());
    }

    public static function count(): int
    {
        return Query::select(['COUNT(*)'])
            ->from(static::tableName())
            ->column();
    }

    public static function query(): Query
    {
        return Query::select()
            ->for(static::class)
            ->from(static::tableName());
    }

    public static function all(): array
    {
        return static::query()
            ->orderBy('updated_at')
            ->all();
    }

    public static function find(string $field, string $value): Query
    {
        return static::query()->where($field, $value);
    }

    public static function findOne(string $field, string $value): self
    {
        return static::query()->where($field, $value)->one();
    }

    public static function get(string $id): static
    {
        return static::find('id', $id)->one();
    }

    public static function getOr404(int $id)
    {
        $model = static::get($id);

        if ($model->isEmpty()) {
            throw new Http404Exception('Page not found');
        }

        return $model;
    }

    public static function create(array $data): static
    {
        $obj = new static;

        if (empty($obj->fillable)) {
            throw new Exception('The property "fillable" in ' . static::class . ' is empty!');
        }

        $allowed = array_filter(
            $data,
            fn($k) => in_array($k, $obj->fillable),
            ARRAY_FILTER_USE_KEY
        );

        if (empty($allowed)) {
            throw new Exception('The property "allowed" in ' . static::class . ' is empty!');
        }

        foreach ($allowed as $field => $datum) {
            $obj->$field = $datum;
        }

        $query = Query::insert(static::tableName(), $allowed)
            ->execute();

        $obj->id = $query->lastId();

        return $obj;
    }

    public function save()
    {
        if (!$this->recordModeIsEnable()) {
            throw new Exception('Recording mode not enabled');
        }

        $this->isNew() ? $this->insert() : $this->update();
        $this->recordModeDisable();
    }

    protected function isNew(): bool
    {
        return !isset($this->id);
    }

    protected function insert()
    {
        $query = Query::insert(static::tableName(), $this->changedFields)
            ->execute();

        $this->id = $query->lastId();

        $query->result();
    }

    protected function update()
    {
        Query::update(static::tableName(), $this->changedFields)
            ->where('id', $this->id)
            ->execute()
            ->result();
    }

    public function delete()
    { 
        Query::delete()
            ->from(static::tableName())
            ->where('id', $this->id)
            ->execute()
            ->result();
    }
}