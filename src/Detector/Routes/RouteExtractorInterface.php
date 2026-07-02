<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector\Routes;

use AIProjectScanner\DTO\RouteDiscoveryResult;
use AIProjectScanner\DTO\ScanResult;

interface RouteExtractorInterface
{

    public function extract(
        ScanResult $scanResult,
        string $projectRoot,
        RouteDiscoveryResult $result
    ): void;
}
