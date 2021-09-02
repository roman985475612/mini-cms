<?php

namespace Home\CmsMini\Db;

class Constrain
{
    const RESTRICT = 'RESTRICT';

    const CASCADE = 'CASCADE';

    const SETNULL = 'SET NULL';

    const NOACTION = 'NO ACTION';

    protected $sql;

    public function __toString()
    {
        return implode(' ' , $this->sql);
    }

    public static function foreignKey(string $indexName): self
    {
        $obj = new self;
        $obj->sql[] = "FOREIGN KEY ({$indexName})" . PHP_EOL;
        
        return $obj;
    }

    public function references(string $tableName, string $indexColumnName)
    {
        $this->sql[] = "REFERENCES {$tableName} ({$indexColumnName})" . PHP_EOL;
        return $this;
    }

    public function update($value): self
    {
        $this->sql[] = "ON UPDATE $value" . PHP_EOL;
        return $this;
    }

    public function delete($value): self
    {
        $this->sql[] = "ON DELETE $value" . PHP_EOL;
        return $this;
    }

}
