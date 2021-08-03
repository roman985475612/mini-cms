<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Home\CmsMini\Db;

$argsList = getArgs($argc, $argv);

$filepath = __DIR__ . '/migrations/' . $argsList[0] . '.sql';

if (!file_exists($filepath)) {
    exit('File not found');
}

ob_start();
include $filepath;
$sql = ob_get_clean();

$query = Db::query($sql);
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