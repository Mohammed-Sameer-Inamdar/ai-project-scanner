<?php

declare(strict_types=1);

namespace AIProjectScanner\Utils;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Core\Constants;

final class IgnorePatternLoader
{
    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {
    }

    /**
     * @return list<string>
     */
    public function load(string $projectRoot): array
    {
        $patterns = [];

        $patterns = array_merge(
            $patterns,
            $this->loadFromFile($projectRoot . DIRECTORY_SEPARATOR . Constants::DEFAULT_IGNORE_FILE),
            $this->loadFromFile($projectRoot . DIRECTORY_SEPARATOR . '.gitignore'),
            Constants::DEFAULT_PATTERNS
        );

        return array_values(array_unique($patterns));
    }

    /**
     * @return list<string>
     */
    private function loadFromFile(string $path): array
    {
        if (!$this->fileSystem->isFile($path)) {
            return [];
        }

        $content = $this->fileSystem->read($path);
        $lines = preg_split('/\R/', $content);

        if ($lines === false) {
            return [];
        }

        return array_values(array_filter(array_map(
            fn (string $line): string => trim($line),
            $lines
        ), fn (string $line): bool => $line !== '' && !str_starts_with($line, '#')));
    }
}