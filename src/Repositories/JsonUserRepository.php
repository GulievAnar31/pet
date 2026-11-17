<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;
use App\Shared\File;

readonly class JsonUserRepository implements UserRepositoryInterface
{
    public function __construct(private File $file)
    {
    }

    /**
     * @return User[]
     * @throws \JsonException
     */
    public function all(): array
    {
        $content = $this->read();

        return array_map(
            static fn (array $item): User => User::fromArray($item),
            $content['users']
        );
    }

    /**
     * @throws \JsonException
     */
    public function add(string $name, string $surname, string $email): User
    {
        $content = $this->read();

        // lastId только растёт: удаление его не трогает, поэтому id никогда не повторяется
        $newId = $content['lastId'] + 1;

        $user = new User($newId, $name, $surname, $email);

        $content['users'][] = $user->toArray();
        $content['lastId'] = $newId;

        $this->file->write($content);

        return $user;
    }

    /**
     * @throws \JsonException
     */
    public function delete(int $id): void
    {
        $content = $this->read();
        $countBefore = count($content['users']);

        $content['users'] = array_values(array_filter(
            $content['users'],
            static fn (array $item): bool => $item['id'] !== $id
        ));

        if (count($content['users']) === $countBefore) {
            throw new \InvalidArgumentException("Пользователь с id {$id} не найден");
        }

        $this->file->write($content);
    }

    /**
     * @throws \JsonException
     */
    private function read(): array
    {
        return $this->file->read();
    }
}
