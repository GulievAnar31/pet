<?php

namespace App\Commands;

use App\Repositories\UserRepositoryInterface;

readonly class DeleteUserCommand
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {

    }

    public function execute(int $id): void
    {
        $this->userRepository->delete($id);

        echo "Удалён пользователь #{$id}\n";
    }
}
