<?php

declare(strict_types=1);

namespace App\Shared;

use App\Repositories\UserRepositoryInterface;

readonly class Commands
{
    public function __construct(private UserRepositoryInterface $users)
    {
    }

    /**
     * @param string[] $args
     * @throws \JsonException
     */
    public function execute(string $cmd, array $args): void
    {
        $params = $this->parseParams($args);

        match ($cmd) {
            'users:show' => $this->showUsers(),
            'user:add' => $this->addUser($params),
            'user:delete' => $this->deleteUser($params),
            default => throw new \InvalidArgumentException(
                "Неизвестная команда «{$cmd}». Доступны: users:show, user:add, user:delete"
            ),
        };
    }

    /**
     * @throws \JsonException
     */
    private function showUsers(): void
    {
        $users = $this->users->all();

        if ($users === []) {
            echo "Пользователей нет\n";
            return;
        }

        foreach ($users as $user) {
            echo "#{$user->getId()} {$user->getName()} {$user->getSurname()} <{$user->getEmail()}>\n";
        }
    }

    /**
     * @param array<string, string> $params
     * @throws \JsonException
     */
    private function addUser(array $params): void
    {
        $user = $this->users->add(
            $params['name'] ?? '',
            $params['surname'] ?? '',
            $params['email'] ?? ''
        );

        echo "Добавлен пользователь #{$user->getId()}\n";
    }

    /**
     * @param array<string, string> $params
     * @throws \JsonException
     */
    private function deleteUser(array $params): void
    {
        $id = $params['id'] ?? '';

        if (!ctype_digit($id)) {
            throw new \InvalidArgumentException('Укажите числовой id, например: make user-delete id=5');
        }

        $this->users->delete((int) $id);

        echo "Удалён пользователь #{$id}\n";
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
