<?php

declare(strict_types=1);

namespace AIProjectScanner\Core;

final class ScanContext
{

    public function __construct(
        private readonly string $projectRoot,
        private readonly string $outputDirectory = Constants::DEFAULT_OUTPUT_DIRECTORY,
        private readonly bool $verbose = false
    ) {
        
    }

    public function getProjectRoot(): string
    {
        return $this->projectRoot;
    }

    public function getOutputDirectory(): string
    {
        return $this->outputDirectory;
    }

    public function isVerbose(): bool
    {
        return $this->verbose;
    }
}
