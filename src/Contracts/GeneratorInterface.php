<?php

declare(strict_types=1);

namespace AIProjectScanner\Contracts;

use AIProjectScanner\DTO\ScanResult;

interface GeneratorInterface
{
    public function generate(
        ScanResult $result,
        string $outputDirectory
    ): void;
}