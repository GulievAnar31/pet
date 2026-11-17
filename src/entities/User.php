<?php

declare(strict_types=1);

namespace App\Entities;

readonly class User
{
    public function __construct(
        private int    $id,
        private string $name,
        private string $surname,
        private string $email
    ) {
        self::assertId($this->id);
        self::assertName($this->name, 'name');
        self::assertName($this->surname, 'surname');
        self::assertEmail($this->email);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    private static function assertId(int $id): void
    {
        if ($id < 1) {
            throw new \InvalidArgumentException('User ID must be greater than 0');
        }
    }

    private static function assertName(string $value, string $field): void
    {
        if (mb_strlen(trim($value), 'UTF-8') < 3) {
            throw new \InvalidArgumentException("User {$field} must be at least 3 characters long");
        }
    }

    private static function assertEmail(string $email): void
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('User email must be a valid email address');
        }
    }

    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (string) $data['name'],
            (string) $data['surname'],
            (string) $data['email']
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email
        ];
    }
}
