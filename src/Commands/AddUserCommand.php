<?php

namespace App\Commands;

use App\Repositories\UserRepositoryInterface;

readonly class AddUserCommand
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }

    public function execute(string $name = "", string $surname = "", string $email = ""): void
    {
        $user = $this->userRepository->add(
            $name ?? "",
            $surname ?? "",
            $email ?? ""
        );

        echo "Добавлен пользователь #{$user->getId()}\n";
    }
}
