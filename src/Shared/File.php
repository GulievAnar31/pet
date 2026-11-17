<?php

declare(strict_types=1);

namespace App\Shared;

readonly class File
{
    public function __construct(private string $path)
    {
    }

    /**
     * @throws \JsonException
     */
    public function read(): array
    {
        $content = file_get_contents($this->path);

        if ($content === false) {
            throw new \RuntimeException("Не удалось прочитать файл {$this->path}");
        }

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @throws \JsonException
     */
    public function write(array $data): void
    {
        $json = json_encode($data, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        if (file_put_contents($this->path, $json . "\n") === false) {
            throw new \RuntimeException("Не удалось записать файл {$this->path}");
        }
    }
}
