<?php

use App\shared\Commands;
use App\shared\File;

require __DIR__ . "/../vendor/autoload.php";

$file = new File(dirname(__DIR__) . '/users.json');

try {
    $file->readFile();

    $commands = new Commands($file);

    $args = array_splice($argv, 1);
    $cmd = $args[0];

    $commands->execute($cmd, array_slice($args, 1));
} catch (JsonException $e) {
    echo "Не удалось прочитать users.json: {$e->getMessage()}\n";
    exit(1);
}
