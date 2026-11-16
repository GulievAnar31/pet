<?php

use entities\File;
use entities\Commands;

require_once "entities/File.php";
require_once "entities/Commands.php";

$file = new File(dirname(__DIR__) . '/users.json');

try {
    $file->readFile();
} catch (JsonException $e) {
    echo "Не удалось прочитать users.json: {$e->getMessage()}\n";
    exit(1);
}

$commands = new Commands($file);

$args = array_splice($argv, 1);
$cmd = $args[0];

$commands->execute($cmd);
