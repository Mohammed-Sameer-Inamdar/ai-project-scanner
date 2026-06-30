<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\FrameworkDetectionResult;
use AIProjectScanner\DTO\ScanResult;

final class FrameworkDetector
{
    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {
    }

    public function detect(
        ScanResult $scanResult,
        string $projectRoot
    ): FrameworkDetectionResult {
        $frameworks = [];

        if ($this->hasFile($scanResult, 'spark') && $this->hasDirectory($scanResult, 'app/Config')) {
            $frameworks[] = 'CodeIgniter4';
        }

        if ($this->hasFile($scanResult, 'artisan')) {
            $frameworks[] = 'Laravel';
        }

        foreach ($scanResult->getFiles() as $file) {
            if (!$file instanceof FileNode) {
                continue;
            }

            if (!str_ends_with($file->getPath(), 'package.json')) {
                continue;
            }

            $frameworks[] = 'Node.js';

            $packageJsonPath = $projectRoot . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file->getPath());
            $content = $this->fileSystem->read($packageJsonPath);

            if (str_contains($content, '"react"')) {
                $frameworks[] = 'React';
            }

            if (str_contains($content, '"next"')) {
                $frameworks[] = 'Next.js';
            }

            if (str_contains($content, '"express"')) {
                $frameworks[] = 'Express';
            }

            if (str_contains($content, '"vue"')) {
                $frameworks[] = 'Vue';
            }
        }

        return new FrameworkDetectionResult(
            array_values(array_unique($frameworks))
        );
    }

    private function hasFile(ScanResult $scanResult, string $path): bool
    {
        foreach ($scanResult->getFiles() as $file) {
            if ($file instanceof FileNode && $file->getPath() === $path) {
                return true;
            }
        }

        return false;
    }

    private function hasDirectory(ScanResult $scanResult, string $path): bool
    {
        foreach ($scanResult->getDirectories() as $directory) {
            if ($directory->getPath() === $path) {
                return true;
            }
        }

        return false;
    }
}