<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class Module
{
    /**
     * @param array<string> $files
     */
    public function __construct(
        private readonly string $name,
        private readonly array $files
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array<string>
     */
    public function getFiles(): array
    {
        return $this->files;
    }
}