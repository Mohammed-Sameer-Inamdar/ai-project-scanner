<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector\Routes;

use AIProjectScanner\DTO\RouteDiscoveryResult;
use AIProjectScanner\DTO\ScanResult;

final class ExpressRouteExtractor implements RouteExtractorInterface
{
    public function extract(
        ScanResult $scanResult,
        string $projectRoot,
        RouteDiscoveryResult $result
    ): void {
        // Implement the logic to extract routes from Express.js projects

        }
        
}