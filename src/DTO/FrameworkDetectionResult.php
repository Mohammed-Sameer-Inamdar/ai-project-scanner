<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class FrameworkDetectionResult
{
    /**
     * @param array<string> $frameworks
     */
    public function __construct(
        private readonly array $frameworks
    ) {
    }

    /**
     * @return array<string>
     */
    public function getFrameworks(): array
    {
        return $this->frameworks;
    }

    public function hasFramework(string $framework): bool
    {
        return in_array(
            $framework,
            $this->frameworks,
            true
        );
    }
}