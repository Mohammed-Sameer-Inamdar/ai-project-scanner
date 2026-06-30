<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class ProjectStructureResult
{
    /**
     * @param array<string> $backendEntryPoints
     * @param array<string> $frontendEntryPoints
     * @param array<string> $routeFiles
     * @param array<string> $controllerFiles
     * @param array<string> $serviceFiles
     * @param array<string> $modelFiles
     * @param array<string> $databaseFiles
     * @param array<string> $configFiles
     * @param array<string> $testFiles
     * @param array<string> $documentationFiles
     * @param array<string> $deploymentFiles
     */
    public function __construct(
        private readonly array $backendEntryPoints,
        private readonly array $frontendEntryPoints,
        private readonly array $routeFiles,
        private readonly array $controllerFiles,
        private readonly array $serviceFiles,
        private readonly array $modelFiles,
        private readonly array $databaseFiles,
        private readonly array $configFiles,
        private readonly array $testFiles,
        private readonly array $documentationFiles,
        private readonly array $deploymentFiles
    ) {
    }

    public function getBackendEntryPoints(): array
    {
        return $this->backendEntryPoints;
    }

    public function getFrontendEntryPoints(): array
    {
        return $this->frontendEntryPoints;
    }

    public function getRouteFiles(): array
    {
        return $this->routeFiles;
    }

    public function getControllerFiles(): array
    {
        return $this->controllerFiles;
    }

    public function getServiceFiles(): array
    {
        return $this->serviceFiles;
    }

    public function getModelFiles(): array
    {
        return $this->modelFiles;
    }

    public function getDatabaseFiles(): array
    {
        return $this->databaseFiles;
    }

    public function getConfigFiles(): array
    {
        return $this->configFiles;
    }

    public function getTestFiles(): array
    {
        return $this->testFiles;
    }

    public function getDocumentationFiles(): array
    {
        return $this->documentationFiles;
    }

    public function getDeploymentFiles(): array
    {
        return $this->deploymentFiles;
    }
}