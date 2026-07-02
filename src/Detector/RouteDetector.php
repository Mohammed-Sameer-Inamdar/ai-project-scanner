<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Detector\Routes\CodeIgniterRouteExtractor;
use AIProjectScanner\Detector\Routes\LaravelRouteExtractor;
use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\RouteDefinition;
use AIProjectScanner\DTO\RouteDiscoveryResult;
use AIProjectScanner\DTO\ScanResult;

final class RouteDetector
{
    private const CI4_DIRECT_METHODS = [
        'add',
        'get',
        'post',
        'put',
        'head',
        'options',
        'delete',
        'patch',
    ];

    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {}

    public function detect(
        ScanResult $scanResult,
        string $projectRoot
    ): RouteDiscoveryResult {

        $extractors = $this->getExtractors();

        $result = new RouteDiscoveryResult();

        foreach ($extractors as $extractor) {
            $extractor->extract($scanResult, $projectRoot, $result);
        }

        return $result;
    }

    private function    getExtractors(): array
    {
        return [
            new CodeIgniterRouteExtractor($this->fileSystem),
            new LaravelRouteExtractor($this->fileSystem),
        ];
    }
}
