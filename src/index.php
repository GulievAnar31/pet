<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Commands\AddUserCommand;
use App\Commands\DeleteUserCommand;
use App\Commands\ShowUserCommand;
use App\Formatters\UserConsoleFormatter;
use App\Repositories\JsonUserRepository;
use App\Shared\Commands;
use App\Shared\File;

$repository = new JsonUserRepository(new File(dirname(__DIR__) . '/users.json'));
$addUserCommand = new AddUserCommand($repository);
$deleteUserCommand = new DeleteUserCommand($repository);
$userConsoleFormatter = new UserConsoleFormatter();

$showUserCommand = new ShowUserCommand($repository, new UserConsoleFormatter());

$commands = new Commands($addUserCommand, $deleteUserCommand, $showUserCommand);

$cmd = $argv[1] ?? '';
$args = array_slice($argv, 2);

try {
    $commands->execute($cmd, $args);
} catch (\InvalidArgumentException|\RuntimeException $e) {
    fwrite(STDERR, "Ошибка: {$e->getMessage()}\n");
    exit(1);
} catch (\JsonException $e) {
    fwrite(STDERR, "Не удалось разобрать users.json: {$e->getMessage()}\n");
    exit(1);
}
