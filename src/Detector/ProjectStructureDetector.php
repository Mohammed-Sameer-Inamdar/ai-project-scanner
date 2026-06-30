<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector;

use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\ProjectStructureResult;
use AIProjectScanner\DTO\ScanResult;

final class ProjectStructureDetector
{
    public function detect(
        ScanResult $scanResult
    ): ProjectStructureResult {

        $backendEntryPoints = [];
        $frontendEntryPoints = [];
        $routeFiles = [];
        $controllerFiles = [];
        $serviceFiles = [];
        $modelFiles = [];
        $databaseFiles = [];
        $configFiles = [];
        $testFiles = [];
        $documentationFiles = [];
        $deploymentFiles = [];

        foreach ($scanResult->getFiles() as $file) {

            if (!$file instanceof FileNode) {
                continue;
            }

            $path = $file->getPath();

            $lowerPath = strtolower($path);

            if ($this->isLikelyStaticAsset($lowerPath)) {
                continue;
            }

            if (str_ends_with($lowerPath, '.gitkeep')) {
                continue;
            }

            if ($this->isBackendEntryPoint($lowerPath)) {
                $backendEntryPoints[] = $path;
            }

            $isTestPath = $this->isTestPath($lowerPath);

            if ($isTestPath) {
                $testFiles[] = $path;
                continue;
            }

            if (preg_match('/(^|\/)(main|app)\.(tsx|jsx|vue)$/', $lowerPath)) {
                $frontendEntryPoints[] = $path;
            }

            /*
             * Routes
             */
            if (
                str_contains($lowerPath, 'route')
                || preg_match('/routes?\./', $lowerPath)
            ) {
                $routeFiles[] = $path;
            }

            /*
             * Controllers
             */
            if (
                str_contains($lowerPath, '/controller')
                || str_ends_with($lowerPath, 'controller.php')
                || str_ends_with($lowerPath, 'controller.java')
            ) {
                $controllerFiles[] = $path;
            }

            /*
             * Services
             */
            if (
                str_contains($lowerPath, '/service')
                || str_ends_with($lowerPath, 'service.php')
                || str_ends_with($lowerPath, 'service.java')
            ) {
                $serviceFiles[] = $path;
            }

            /*
             * Models / Entities
             */
            if (
                str_contains($lowerPath, '/model')
                || str_contains($lowerPath, '/entity')
                || str_ends_with($lowerPath, 'model.php')
                || str_ends_with($lowerPath, 'entity.java')
            ) {
                $modelFiles[] = $path;
            }

            /*
             * Database
             */
            if (
                str_contains($lowerPath, 'migration')
                || str_contains($lowerPath, 'seed')
                || str_contains($lowerPath, 'database')
                || str_contains($lowerPath, 'schema')
            ) {
                $databaseFiles[] = $path;
            }

            /*
             * Config
             */
            if (
                str_contains($lowerPath, '/config/')
                || preg_match('/(config|env|yaml|yml|properties|xml)$/', $lowerPath)
            ) {
                $configFiles[] = $path;
            }

            /*
             * Tests
             */
            if (
                str_contains($lowerPath, 'test')
                || str_contains($lowerPath, 'spec')
            ) {
                $testFiles[] = $path;
            }

            /*
             * Documentation
             */
            if (
                str_ends_with($lowerPath, '.md')
                || str_contains($lowerPath, 'docs/')
            ) {
                $documentationFiles[] = $path;
            }

            /*
             * Deployment
             */
            if (
                str_contains($lowerPath, 'docker')
                || str_contains($lowerPath, 'kubernetes')
                || str_contains($lowerPath, '.github/')
                || str_contains($lowerPath, 'deploy')
                || str_contains($lowerPath, 'pipeline')
            ) {
                $deploymentFiles[] = $path;
            }
        }

        return new ProjectStructureResult(
            array_unique($backendEntryPoints),
            array_unique($frontendEntryPoints),
            array_unique($routeFiles),
            array_unique($controllerFiles),
            array_unique($serviceFiles),
            array_unique($modelFiles),
            array_unique($databaseFiles),
            array_unique($configFiles),
            array_unique($testFiles),
            array_unique($documentationFiles),
            array_unique($deploymentFiles)
        );
    }

    private function isLikelyStaticAsset(string $path): bool
    {
        return str_contains($path, '/assets/')
            || str_contains($path, '/admin_assets')
            || str_contains($path, '/uploads/')
            || preg_match('/\.(min\.js|min\.css|png|jpg|jpeg|gif|svg|woff|woff2|ttf|eot)$/', $path) === 1;
    }
    private function isBackendEntryPoint(string $path): bool
    {
        return in_array($path, [
            'index.php',
            'public/index.php',
            'artisan',
            'spark',
            'manage.py',
            'main.py',
            'app.py',
            'server.js',
            'server.ts',
            'cmd/main.go',
        ], true)
            || str_starts_with($path, 'cmd/')
            && str_ends_with($path, '/main.go')
            || str_contains($path, 'src/main/java/')
            && str_ends_with($path, '.java');
    }
    private function isTestPath(string $path): bool
    {
        return str_starts_with($path, 'tests/')
            || str_starts_with($path, 'test/')
            || str_contains($path, '/__tests__/')
            || str_contains($path, '.test.')
            || str_contains($path, '.spec.');
    }
}
