<?php

function d(mixed $data, bool $die = false): void
{
    print_r($data);

    if ($die) { die; }
}

function dd(mixed $data, bool $die = false): void
{
    $styles = <<<STYLE
    display: block;
    padding: 2rem 1rem;
    border-radius: 8px;
    background: #eae8d3;
    font-family:'JetBrains Mono';
    color: #003f5c;
    STYLE;

    echo '<pre style="' . $styles . '">'. print_r($data, true) . '</pre>';
    
    if ($die) { die; }
}

function upperCamelCase(string $name): string
{
    return str_replace(' ', '', ucwords(str_replace('-', ' ', $name)));
}

function lowerCamelCase(string $name): string
{
    return lcfirst(upperCamelCase($name));
}

function removeDirectory($dir) 
{
    if (!file_exists($dir)) {
        throw new Exception("Folder not exists: $dir");
    }

    if ($objs = glob($dir."/*")) {
       foreach($objs as $obj) {
         is_dir($obj) ? removeDirectory($obj) : unlink($obj);
       }
    }
    rmdir($dir);
}

function createDirectoryIfNotExists($dir)
{
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

function array_true_map(array $array, callable $callback): array
{
    $newArr = [];

    foreach ($array as $key => $value) {
        $newArr[] = $callback($value, $key);
    }

    return $newArr;
}

function getRandomPassword(int $passLenght = 8): string
{
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $alphaLength = strlen($alphabet) - 1;
    $pass = [];
    
    for ($i = 0; $i < $passLenght; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    
    return implode($pass);
}
