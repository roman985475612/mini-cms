<?php

namespace Home\CmsMini\Db;

use Home\CmsMini\Db;

class Migration
{
    protected string $folder;

    protected array $sql = [];

    protected Db $db;

    public function __construct()
    {
        $this->folder = dirname(dirname(__DIR__)) . '/Migration';
        
        $config = json_decode(file_get_contents(dirname(dirname(__DIR__)) . '/config/config.json'));

        $this->db = new Db(
            $config->db->host,
            $config->db->name,
            $config->db->user,
            $config->db->pass
        );
    }

    public function init()
    {
        if (!file_exists($this->folder)) {
            mkdir($this->folder, 0777, true);
        }

        $this->createTable('migration', [
            'id' => Column::primary(),
            'name' => Column::string(255)->notNull(),
            'created_at' => Column::time()->default(Column::CURRENT_TIME),
            'updated_at' => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);
        $this->db->query($this->sql[0]);
        $this->db->execute();

        echo "Database migration init...";
    }

    public function create(string $table)
    {
        $filename = 'm' . time() . '_create_' . strtolower($table) . '_table';

        $filepath = $this->folder . '/' . $filename . '.php';

        if (file_put_contents($filepath, $this->getMigrationDraft($filename))) {
            echo "Create {$filename}"; 
        }
    }

    public function default()
    {
        $files = scandir($this->folder);
        $files = array_filter($files, function ($value) {
            return !in_array($value, ['.', '..']);
        });

        foreach ($files as $file) {
            $className = explode('.', $file)[0];
            $migrationName = explode('_', $className)[0];
            
            if ($this->migrationAlreadyExists($migrationName)) {
                echo "Migration <{$migrationName}> already exists!\n";
                continue;
            }
        
            $filepath = "{$this->folder}/{$className}.php";
            if (!file_exists($filepath)) {
                echo "Migration <{$migrationName}> not found!\n";
                continue;
            }

            require $filepath;
        
            $class = "\\App\\Migration\\{$className}";

            $obj = new $class;
            $obj->up();
    
            foreach ($obj->sql as $sql) {
                $this->db->query($sql);
                $this->db->execute();
//                echo $this->db->getSql();
            }
    
            $this->migrationRecord($migrationName);
    
            echo "Migration <{$migrationName}> done!" . PHP_EOL;
        }
    }

    protected function migrationAlreadyExists(string $migrationName): bool
    {
        return (bool) (new Query($this->db))
            ->select()
            ->from('migration')
            ->where('name', $migrationName)
            ->count();
    }

    protected function migrationRecord(string $migrationName)
    {
        (new Query($this->db))
            ->insert('migration', [
                'name' => $migrationName,
            ])
            ->execute();
    } 

    protected function createTable(string $tableName, array $columns): void
    {
        $cols = [];
        foreach ($columns as $name => $type) {
            $cols[] = "\t" . $name . ' ' . $type;
        }
        
        $sql = "CREATE TABLE IF NOT EXISTS `{$tableName}` (" . PHP_EOL;
        $sql .= implode(',' . PHP_EOL, $cols) . PHP_EOL;
        $sql .= ") ENGINE = InnoDB;". PHP_EOL;

        $this->sql[] = $sql;
    }

    protected function dropTable(string $tableName): void
    {
    }

    protected function addConstrain(string $tableName, string $idx, Constrain $constrain): void
    {
        $sql = "ALTER TABLE {$tableName}" . PHP_EOL;
        $sql .= "ADD CONSTRAINT {$idx}" . PHP_EOL;
        $sql .= $constrain . ";" . PHP_EOL;

        $this->sql[] = $sql;
    }

    protected function getMigrationDraft(string $filename): string
    {
        $content = file_get_contents(__DIR__ . '/draft.txt');
        $content = str_replace('{{filename}}', $filename, $content);
        return $content;
    }
}