<?php

declare(strict_types=1);

namespace AIProjectScanner\Generator;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Contracts\GeneratorInterface;
use AIProjectScanner\DTO\ScanResult;

final class JsonGenerator implements GeneratorInterface
{
    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {
    }

    public function generate(
        ScanResult $result,
        string $outputDirectory
    ): void
    {
    }
}