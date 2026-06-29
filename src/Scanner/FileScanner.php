<?php

declare(strict_types=1);

namespace AIProjectScanner\Scanner;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Core\ScanContext;
use AIProjectScanner\DTO\DirectoryNode;
use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\ScanResult;
use AIProjectScanner\Utils\IgnoreMatcher;
use AIProjectScanner\Utils\IgnorePatternLoader;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Throwable;

final class FileScanner
{
    public function __construct(
        private readonly FileSystemInterface $fileSystem,
        private readonly IgnorePatternLoader $patternLoader,
        private readonly IgnoreMatcher $ignoreMatcher
    ) {
    }

    public function scan(ScanContext $context): ScanResult
    {
        $projectRoot = rtrim(
            $this->fileSystem->normalizePath($context->getProjectRoot()),
            DIRECTORY_SEPARATOR
        );

        $projectName = basename($projectRoot);
        $patterns = $this->patternLoader->load($projectRoot);

        $directories = [];
        $files = [];
        $ignored = [];
        $errors = [];

        try {
            $directoryIterator = new RecursiveDirectoryIterator(
                $projectRoot,
                RecursiveDirectoryIterator::SKIP_DOTS
            );

            $filterIterator = new RecursiveCallbackFilterIterator(
                $directoryIterator,
                function (SplFileInfo $item) use (
                    $projectRoot,
                    $patterns,
                    &$ignored
                ): bool {
                    $absolutePath = $this->fileSystem->normalizePath(
                        $item->getPathname()
                    );

                    $relativePath = $this->toRelativePath(
                        $absolutePath,
                        $projectRoot
                    );

                    if ($this->ignoreMatcher->shouldIgnore(
                        $relativePath,
                        $patterns
                    )) {
                        $ignored[] = $relativePath;

                        return false;
                    }

                    return true;
                }
            );

            $iterator = new RecursiveIteratorIterator(
                $filterIterator,
                RecursiveIteratorIterator::SELF_FIRST
            );

            foreach ($iterator as $item) {
                $absolutePath = $this->fileSystem->normalizePath(
                    $item->getPathname()
                );

                $relativePath = $this->toRelativePath(
                    $absolutePath,
                    $projectRoot
                );

                if ($item->isDir()) {
                    $directories[] = new DirectoryNode($relativePath);
                    continue;
                }

                if ($item->isFile()) {
                    $files[] = new FileNode(
                        path: $relativePath,
                        extension: pathinfo($relativePath, PATHINFO_EXTENSION),
                        size: $item->getSize()
                    );
                }
            }
        } catch (Throwable $exception) {
            $errors[] = $exception->getMessage();
        }

        return new ScanResult(
            projectName: $projectName,
            directories: $directories,
            files: $files,
            ignored: $ignored,
            errors: $errors
        );
    }

    private function toRelativePath(string $absolutePath, string $projectRoot): string
    {
        $relativePath = str_replace(
            $projectRoot . DIRECTORY_SEPARATOR,
            '',
            $absolutePath
        );

        return str_replace(DIRECTORY_SEPARATOR, '/', $relativePath);
    }
}