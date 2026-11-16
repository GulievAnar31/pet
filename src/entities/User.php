<?php

namespace entities;

class User
{
    public string $name;
    public string $surname;
    public int $id;

    public function __construct(int $id, string $name, string $surname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }
}
