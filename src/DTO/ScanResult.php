<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class ScanResult
{
    public function __construct(
        private readonly string $projectName,
        private readonly array $directories,
        private readonly array $files,
        private readonly array $ignored,
        private readonly array $errors
    ) 
    {
    }

    public function getProjectName(): string
    {
        return $this->projectName;
    }

    public function getDirectories(): array
    {
        return $this->directories;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function getIgnored(): array
    {
        return $this->ignored;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

}