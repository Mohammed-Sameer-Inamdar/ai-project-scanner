<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector;

use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\Module;
use AIProjectScanner\DTO\ModuleDiscoveryResult;
use AIProjectScanner\DTO\ScanResult;

final class ModuleDetector
{
    private const IGNORED_MODULE_NAMES = [
        'BaseController',
        'Home',
        'Common',
        'index',
        'welcome',
    ];

    public function detect(ScanResult $scanResult): ModuleDiscoveryResult
    {
        $modules = [];

        foreach ($scanResult->getFiles() as $file) {
            if (!$file instanceof FileNode) {
                continue;
            }

            $moduleName = $this->detectModuleName($file->getPath());

            if ($moduleName === null) {
                continue;
            }

            $modules[$moduleName][] = $file->getPath();
        }

        ksort($modules);

        return new ModuleDiscoveryResult(
            array_map(
                fn (string $name, array $files): Module => new Module(
                    name: $name,
                    files: $files
                ),
                array_keys($modules),
                array_values($modules)
            )
        );
    }

    private function detectModuleName(string $path): ?string
    {
        $basename = pathinfo($path, PATHINFO_FILENAME);

        $basename = preg_replace('/(Controller|Model|Service|Repository)$/', '', $basename);
        $basename = preg_replace('/(_details|_detail|_list|_form|_page)$/i', '', $basename);

        if (!is_string($basename) || $basename === '') {
            return null;
        }

        $name = $this->normalizeModuleName($basename);

        if (in_array($name, self::IGNORED_MODULE_NAMES, true)) {
            return null;
        }

        return $name;
    }

    private function normalizeModuleName(string $name): string
    {
        $name = str_replace(['-', '_'], ' ', $name);
        $name = ucwords($name);
        $name = str_replace(' ', '', $name);

        if (str_ends_with($name, 'ies')) {
            return substr($name, 0, -3) . 'y';
        }

        if (str_ends_with($name, 's') && strlen($name) > 3) {
            return substr($name, 0, -1);
        }

        return $name;
    }
}