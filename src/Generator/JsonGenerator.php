<?php

declare(strict_types=1);

namespace AIProjectScanner\Generator;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Contracts\GeneratorInterface;
use AIProjectScanner\Core\Constants;
use AIProjectScanner\DTO\DirectoryNode;
use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\ScanResult;

final class JsonGenerator implements GeneratorInterface
{
    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {
    }

    public function generate(
        ScanResult $result,
        string $outputDirectory
    ): void {
        $this->fileSystem->ensureDirectoryExists($outputDirectory);

        $data = [
            'projectName' => $result->getProjectName(),
            'statistics' => [
                'directories' => count($result->getDirectories()),
                'files' => count($result->getFiles()),
                'ignored' => count($result->getIgnored()),
                'errors' => count($result->getErrors()),
            ],
            'directories' => $this->mapDirectories(
                $result->getDirectories()
            ),
            'files' => $this->mapFiles(
                $result->getFiles()
            ),
            'ignored' => $result->getIgnored(),
            'errors' => $result->getErrors(),
        ];

        $this->fileSystem->write(
            $outputDirectory . DIRECTORY_SEPARATOR . Constants::PROJECT_MAP,
            json_encode(
                $data,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            )
        );
    }

    /**
     * @param array<DirectoryNode> $directories
     */
    private function mapDirectories(array $directories): array
    {
        return array_map(
            fn (DirectoryNode $directory): string => $directory->getPath(),
            $directories
        );
    }

    /**
     * @param array<FileNode> $files
     */
    private function mapFiles(array $files): array
    {
        return array_map(
            fn (FileNode $file): array => [
                'path' => $file->getPath(),
                'extension' => $file->getExtension(),
                'size' => $file->getSize(),
            ],
            $files
        );
    }
}