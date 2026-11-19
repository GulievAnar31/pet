<?php

declare(strict_types=1);

namespace App\Shared;

use App\Commands\AddUserCommand;
use App\Commands\DeleteUserCommand;
use App\Commands\ShowUserCommand;
use App\Repositories\UserRepositoryInterface;

readonly class Commands
{
    public function __construct(
        private AddUserCommand $addUserCommand,
        private DeleteUserCommand $deleteUserCommand,
        private ShowUserCommand $showUserCommand,
    ) {
    }

    /**
     * @param string[] $args
     * @throws \JsonException
     */
    public function execute(string $cmd, array $args): void
    {
        $params = $this->parseParams($args);

        match ($cmd) {
            'users:show' => $this->showUserCommand->execute(),
            'user:add' => $this->addUserCommand->execute($params['name'], $params['surname'], $params['email']),
            'user:delete' => $this->deleteUserCommand->execute((int) $params['id']),
            default => throw new \InvalidArgumentException(
                "Неизвестная команда «{$cmd}». Доступны: users:show, user:add, user:delete"
            ),
        };
    }

    /**
     * @param string[] $args
     * @return array<string, string>
     */
    private function parseParams(array $args): array
    {
        $result = [];

        foreach ($args as $arg) {
            $parts = explode('=', $arg, 2);

            if (count($parts) !== 2) {
                throw new \InvalidArgumentException("Параметр «{$arg}» должен быть в формате ключ=значение");
            }

            [$key, $value] = $parts;
            $result[trim($key)] = trim($value);
        }

        return $result;
    }
}
