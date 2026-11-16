<?php

namespace entities;

use entities\File;
use entities\User;

require_once "User.php";

class Commands
{
    public File $file;

    public function __construct(File $file)
    {
        $this->file = $file;
    }

    public function execute(string $cmd): void
    {
        match ($cmd) {
            "user:add" => $this->addUser($this->file),
            "user:delete" => $this->deleteUser($this->file),
            "users:show" => $this->showUsers($this->file),
        };
    }

    public function showUsers($file): void
    {
        var_dump($file->getContent()["users"]);
    }

    public function addUser(mixed $file): void
    {
        print_r("Введите имя: \n");
        $name = trim(fgets(STDIN));
        print_r("Введите фамилию: \n");
        $surname = trim(fgets(STDIN));

        $content = $file->getContent();

        // id берём из отдельного счётчика: удаление его не уменьшает,
        // поэтому id никогда не повторяется
        $newId = $content["lastId"] + 1;

        $content["users"][] = new User($newId, $name, $surname);
        $content["lastId"] = $newId;

        $file->syncFile($content);
    }

    public function deleteUser(mixed $file): void
    {
        print_r("Введите id: \n");
        $id = (int) trim(fgets(STDIN));

        $content = $file->getContent();

        $content["users"] = array_values(array_filter($content["users"], static function ($item) use ($id) {
            return $item["id"] !== $id;
        }));

        $file->syncFile($content);
    }
}
