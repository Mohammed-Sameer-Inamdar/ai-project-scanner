<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

use AIProjectScanner\DTO\FrameworkDetectionResult;
use AIProjectScanner\DTO\ScanResult;

final class AnalysisResult
{
    public function __construct(
        private readonly ScanResult $scanResult,
        private readonly FrameworkDetectionResult $frameworkDetectionResult
    ) {
    }

    public function getScanResult(): ScanResult
    {
        return $this->scanResult;
    }

    public function getFrameworkDetectionResult(): FrameworkDetectionResult
    {
        return $this->frameworkDetectionResult;
    }
}