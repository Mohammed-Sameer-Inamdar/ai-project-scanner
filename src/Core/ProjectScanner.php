<?php

declare(strict_types=1);

namespace AIProjectScanner\Core;

use AIProjectScanner\Contracts\GeneratorInterface;
use AIProjectScanner\DTO\ScanResult;
use AIProjectScanner\Scanner\FileScanner;

final class ProjectScanner
{
    /**
     * @param array<GeneratorInterface> $generators
     */
    public function __construct(
        private readonly FileScanner $fileScanner,
        private readonly array $generators
    ) {
    }

    public function scan(ScanContext $context): ScanResult
    {
        $result = $this->fileScanner->scan($context);

        foreach ($this->generators as $generator) {
            $generator->generate(
                $result,
                $context->getOutputDirectory()
            );
        }

        return $result;
    }
}