<?php

namespace App\shared;

use App\entities\User;

class Commands
{
    public function __construct(public File $file)
    {
    }

    public function execute(string $cmd, mixed $params): void
    {
        match ($cmd) {
            "user:add" => $this->addUser($this->file, $params),
            "user:delete" => $this->deleteUser($this->file, $params),
            "users:show" => $this->showUsers($this->file),
        };
    }

    public function showUsers(File $file): void
    {
        var_dump($file->getContent()["users"]);
    }

    public function parseParams(mixed $params): array
    {
        $result = [];

        foreach ($params as $param) {
            $parts = explode("=", $param);

            if (count($parts) !== 2) {
                throw new \RuntimeException("Invalid param");
            }

            [$key, $value] = $parts;

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @throws \JsonException
     */
    public function addUser(File $file, mixed $params): void
    {
        $params = $this->parseParams($params);

        $content = $file->getContent();

        $newId = $content["lastId"] + 1;

        $user = new User($newId, $params["name"], $params["surname"], $params["email"]);

        $content["users"][] = $user;
        $content["lastId"] = $newId;

        $file->syncFile($content);
    }

    public function deleteUser(File $file, mixed $params): void
    {
        $id = $params[0];

        $content = $file->getContent();

        if ($id > $content["lastId"] || $id < 0) {
            throw new \RuntimeException("Invalid param");
        }

        $content["users"] = array_values(array_filter($content["users"], static function ($item) use ($id) {
            return $item["id"] !== (int) $id;
        }));

        $file->syncFile($content);
    }
}
