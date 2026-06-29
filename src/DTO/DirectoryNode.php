<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class DirectoryNode
{
    public function __construct(
        private readonly string $path
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }
}