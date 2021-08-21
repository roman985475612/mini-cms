<?php declare(strict_types=1);

require __DIR__ . '/bootstrap/init.php';

use Home\CmsMini\Db;

$argsList = getArgs($argc, $argv);

$pattern = ROOT . '/migrations/' . $argsList[0] . '_*.sql';

$filename = glob($pattern)[0];

if (!file_exists($filename)) {
    exit('File not found');
}

echo "\t" . $filename . "\n";

ob_start();
include $filename;
$sql = ob_get_clean();

echo $sql . "\n";

$config = json_decode(file_get_contents(CONFIG . '/config.json'));

Db::instance(
    $config->db->host,
    $config->db->name,
    $config->db->user,
    $config->db->pass
);

$query = \Home\CmsMini\Db::query($sql);
echo $query->execute()->rowCount();

function getArgs($argc, $argv)
{
    $result = [];
    for ($i = 1; $i < $argc; $i++) {
        if (strpos($argv[$i], '=')) {
            $arg = explode('=', $argv[$i]);
            $result[ltrim($arg[0], '--')] = $arg[1];
        } else {
            $result[] = $argv[$i];
        }

    }
    return $result;    
}