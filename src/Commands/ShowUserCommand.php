<?php

namespace App\Commands;

use App\Formatters\UserConsoleFormatter;
use App\Repositories\UserRepositoryInterface;

readonly class ShowUserCommand
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserConsoleFormatter $userConsoleFormatter,
    ) {
    }

    /**
     * @throws \JsonException
     */
    public function execute(): void
    {
        $usersToString = $this->userConsoleFormatter->format($this->repository->all());

        echo $usersToString;
    }
}
