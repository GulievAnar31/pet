<?php

namespace App\entities;

class User
{
    public function __construct(
        public int $id,
        public string $name,
        public string $surname,
        public string $email
    ) {
        self::assertId($this->id);
        self::assertName($this->name);
        self::assertName($this->surname);
        self::assertEmail($this->email);
    }

    private static function assertId(int $id): void
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('User ID must be greater than 0');
        }
    }

    private static function assertName(string $name): void
    {
        if (mb_strlen($name, 'UTF-8') < 3) {
            throw new \InvalidArgumentException('User name must be at least 3 characters long');
        }
    }

    private static function assertEmail(string $email): void
    {
        self::assertName($email);

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('User email must be a valid email address');
        }
    }
}
