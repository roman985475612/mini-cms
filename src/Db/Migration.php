<?php

namespace Home\CmsMini\Db;

use Exception;

class Migration
{
    protected $dbh;

    protected $folder;

    protected $sql = [];

    public function __construct()
    {
        $this->dbh = Connection::get();
        $this->folder = dirname(__DIR__, 2) . '/Migration';
    }

    public function init()
    {
        if (!file_exists($this->folder)) {
            mkdir($this->folder, 0777, true);
        }

        $this->createTable('migration', [
            'id' => Column::primary(),
            'name' => Column::string()->notNull(),
            'created_at' => Column::time()->default(Column::CURRENT_TIME),
            'updated_at' => Column::time()->default(Column::CURRENT_TIME)->update(Column::CURRENT_TIME),
        ]);

        $result = $this->dbh
                    ->prepare($this->sql[0])
                    ->execute();

        if (!$result) {
            throw new Exception('Error create migration table');
        }

        echo 'Create table "migration"' . PHP_EOL;

        $migrationName = 'Initial migration';

        if ($this->migrationAlreadyExists($migrationName)) {
            echo "Migration \"$migrationName\" already exists!\n";
            exit;
        }
        
        $this->migrationRecord($migrationName);

        echo "Database migration init...";
    }

    public function create(string $table)
    {
        $filename = 'm' . time() . '_create_' . strtolower($table) . '_table';

        $filepath = $this->folder . '/' . $filename . '.php';

        if (file_put_contents($filepath, $this->getMigrationDraft($filename))) {
            echo "Create $filename";
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
                echo "Migration <$migrationName> already exists!\n";
                continue;
            }
        
            $filepath = "$this->folder/$className.php";
            if (!file_exists($filepath)) {
                echo "Migration <$migrationName> not found!\n";
                continue;
            }

            require $filepath;
        
            $class = "\\App\\Migration\\$className";

            $obj = new $class;
            $obj->up();

            foreach ($obj->sql as $sql) {
                $this->dbh->prepare($sql)->execute();
            }
    
            $this->migrationRecord($migrationName);
    
            echo "Migration \"$migrationName\" done!" . PHP_EOL;
        }
    }

    public function down()
    {
        $migrationName = $this->getLastMigration();

        $filepath = glob("$this->folder/$migrationName*.php")[0];

        $pattern = "#$migrationName\w+#";

        preg_match($pattern, $filepath, $matches);

        $className = $matches[0];
        
        require $filepath;
        
        $class = "\\App\\Migration\\$className";

        $obj = new $class;
        $obj->down();

        $this->dbh->prepare($obj->sql[0])->execute();
        $this->migrationDelete($migrationName);
    
        echo "Migration \"$migrationName\" down!" . PHP_EOL;
    }

    protected function getLastMigration(): string
    {
        return Query::select(['name'])
            ->from('migration')
            ->orderBy('id', false)
            ->limit(1)
            ->column();
    }

    protected function migrationAlreadyExists(string $migrationName): bool
    {
        return (bool) Query::select(['count(*)'])
            ->from('migration')
            ->where('name', $migrationName)
            ->column();
    }

    protected function migrationRecord(string $migrationName): bool
    {
        return Query::insert('migration', ['name' => $migrationName])
            ->execute()
            ->result();
    } 

    protected function migrationDelete(string $migrationName): bool
    {
        return Query::delete()
            ->from('migration')
            ->where('name', $migrationName)
            ->execute()
            ->result();
    } 

    protected function createTable(string $tableName, array $columns): void
    {
        $cols = [];
        foreach ($columns as $name => $type) {
            $cols[] = "\t" . $name . ' ' . $type;
        }
        
        $sql = "CREATE TABLE IF NOT EXISTS `$tableName` (" . PHP_EOL;
        $sql .= implode(',' . PHP_EOL, $cols) . PHP_EOL;
        $sql .= ") ENGINE = InnoDB;". PHP_EOL;

        $this->sql[] = $sql;
    }

    protected function dropTable(string $tableName): void
    {
        $this->sql[] = "DROP TABLE IF EXISTS `$tableName`;";
    }

    protected function addConstrain(string $tableName, string $idx, Constrain $constrain): void
    {
        $sql = "ALTER TABLE $tableName" . PHP_EOL;
        $sql .= "ADD CONSTRAINT $idx" . PHP_EOL;
        $sql .= $constrain . ";" . PHP_EOL;

        $this->sql[] = $sql;
    }

    protected function getMigrationDraft(string $filename): string
    {
        $content = file_get_contents(__DIR__ . '/draft.txt');
        return str_replace('{{filename}}', $filename, $content);
    }
}