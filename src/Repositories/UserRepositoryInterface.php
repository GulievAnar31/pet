<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Entities\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function all(): array;

    public function add(string $name, string $surname, string $email): User;

    /**
     * @throws \InvalidArgumentException если пользователя с таким id нет
     */
    public function delete(int $id): void;
}
