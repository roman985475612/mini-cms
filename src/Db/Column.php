<?php

namespace Home\CmsMini\Db;

class Column
{
    const CURRENT_TIME = 'CURRENT_TIMESTAMP';

    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SETNULL = 'SET NULL';

    const NOACTION = 'NO ACTION';

    protected $sql;
    
    public function __toString()
    {
        return implode(' ' , $this->sql);
    }
    
    public static function primary(): self
    {
        $obj = new self;
        $obj->sql[] = 'SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY';
        
        return $obj;
    }
    
    public static function foreignKey(): self
    {
        $obj = new self;
        $obj->sql[] = 'SMALLINT UNSIGNED NOT NULL';
        
        return $obj;
    }
    
    public static function time(): self
    {
        $obj = new self;
        $obj->sql[] = 'TIMESTAMP';
        
        return $obj;
    }

    public static function string(int $num = 255): self
    {
        $obj = new self;
        $obj->sql[] = "VARCHAR($num)";

        return $obj;
    }

    public static function text(): self
    {
        $obj = new self;
        $obj->sql[] = 'TEXT';

        return $obj;
    }

    public static function bool(): self
    {
        $obj = new self;
        $obj->sql[] = 'BOOLEAN';

        return $obj;
    }

    public static function enum(array $list): self
    {
        $list = array_map(function ($item) {
            return "'{$item}'";
        }, $list);

        $obj = new self;
        $obj->sql[] = 'ENUM(' . implode(',', $list) . ')';

        return $obj;
    }

    public function notNull(): self
    {
        $this->sql[] = 'NOT NULL';
        return $this;
    }
    
    public function default($value): self
    {
        $this->sql[] = "DEFAULT $value";
        return $this;
    }

    public function defaultString(string $value): self
    {
        $this->sql[] = "DEFAULT `$value`";
        return $this;
    }

    public function update($value): self
    {
        $this->sql[] = "ON UPDATE $value";
        return $this;
    }

    public function delete($value): self
    {
        $this->sql[] = "ON DELETE $value";
        return $this;
    }
}