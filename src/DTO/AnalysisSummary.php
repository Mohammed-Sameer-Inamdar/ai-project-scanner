<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class AnalysisSummary
{
    public function __construct(
        private readonly int $routeCount = 0,
        private readonly array $frameworkRouteCounts = []
    ) {
    }

    public function getRouteCount(): int
    {
        return $this->routeCount;
    }

    /**
     * @return array<string, int>
     */
    public function getFrameworkRouteCounts(): array
    {
        return $this->frameworkRouteCounts;
    }
}