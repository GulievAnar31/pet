<?php

namespace entities;

class File
{
    public string $path;
    public array $content;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @throws \JsonException
     */
    public function readFile(): void
    {
        $content = file_get_contents($this->path);

        $this->content = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        ;
    }

    public function syncFile($arr): void
    {
        $json = json_encode($arr, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        file_put_contents($this->path, $json);

        $this->readFile();
    }

    public function getContent(): array
    {
        return $this->content;
    }
}
