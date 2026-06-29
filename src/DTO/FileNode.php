<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class FileNode
{
    public function __construct(
        private readonly string $path,
        private readonly string $extension,
        private readonly int $size
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getSize(): int
    {
        return $this->size;
    }
}
