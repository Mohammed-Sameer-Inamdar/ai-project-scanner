<?php

declare(strict_types=1);

namespace AIProjectScanner\Utils;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\Exceptions\FileSystemException;

final class FileSystem implements FileSystemInterface
{
    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    public function isFile(string $path): bool
    {
        return is_file($path);
    }

    public function isDirectory(string $path): bool
    {
        return is_dir($path);
    }

    public function read(string $path): string
    {
        if (!$this->isFile($path)) {
            throw new FileSystemException("File does not exist: {$path}");
        }

        $content = file_get_contents($path);

        if ($content === false) {
            throw new FileSystemException("Unable to read file: {$path}");
        }

        return $content;
    }

    public function write(string $path, string $content): void
    {
        $directory = dirname($path);

        $this->ensureDirectoryExists($directory);

        if (file_put_contents($path, $content) === false) {
            throw new FileSystemException("Unable to write file: {$path}");
        }
    }

    public function ensureDirectoryExists(string $path): void
    {
        if ($this->isDirectory($path)) {
            return;
        }

        if (!mkdir($path, 0775, true) && !$this->isDirectory($path)) {
            throw new FileSystemException("Unable to create directory: {$path}");
        }
    }

    public function listDirectory(string $path): array
    {
        if (!$this->isDirectory($path)) {
            throw new FileSystemException("Directory does not exist: {$path}");
        }

        $items = scandir($path);

        if ($items === false) {
            throw new FileSystemException("Unable to read directory: {$path}");
        }

        return array_values(array_diff($items, ['.', '..']));
    }

    public function delete(string $path): void
    {
        if (!$this->exists($path)) {
            return;
        }

        if ($this->isFile($path)) {
            if (!unlink($path)) {
                throw new FileSystemException("Unable to delete file: {$path}");
            }

            return;
        }

        if ($this->isDirectory($path)) {
            if (!rmdir($path)) {
                throw new FileSystemException("Unable to delete directory: {$path}");
            }
        }
    }

    public function deleteRecursively(string $path): void
    {
        if (!$this->exists($path)) {
            return;
        }

        if ($this->isFile($path)) {
            $this->delete($path);
            return;
        }

        foreach ($this->listDirectory($path) as $item) {
            $this->deleteRecursively($path . DIRECTORY_SEPARATOR . $item);
        }

        $this->delete($path);
    }

    public function size(string $path): int
    {
        if (!$this->isFile($path)) {
            throw new FileSystemException("File does not exist: {$path}");
        }

        $size = filesize($path);

        if ($size === false) {
            throw new FileSystemException("Unable to get file size: {$path}");
        }

        return $size;
    }

    public function lastModified(string $path): int
    {
        if (!$this->exists($path)) {
            throw new FileSystemException("Path does not exist: {$path}");
        }

        $modified = filemtime($path);

        if ($modified === false) {
            throw new FileSystemException("Unable to get last modified time: {$path}");
        }

        return $modified;
    }

    public function normalizePath(string $path): string
    {
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }
}