<?php

declare(strict_types=1);

namespace AIProjectScanner\Contracts;

use AIProjectScanner\Exceptions\FileSystemException;

interface FileSystemInterface
{
    /**
     * Determines whether a filesystem entry exists.
     */
    public function exists(string $path): bool;

    /**
     * Determines whether the given path is a file.
     */
    public function isFile(string $path): bool;

    /**
     * Determines whether the given path is a directory.
     */
    public function isDirectory(string $path): bool;

    /**
     * Reads the entire contents of a file.
     *
     * @throws FileSystemException
     */
    public function read(string $path): string;

    /**
     * Writes content to a file.
     *
     * Creates missing parent directories automatically.
     * Overwrites the file if it already exists.
     * Creates the file if it does not already exist.
     *
     * @throws FileSystemException
     */
    public function write(string $path, string $content): void;

    /**
     * Ensures that the specified directory exists.
     *
     * Creates the directory and any missing parent directories if necessary.
     * Does nothing if the directory already exists.
     *
     * @throws FileSystemException
     */
    public function ensureDirectoryExists(string $path): void;

    /**
     * Returns the immediate child entries of the specified directory. The special entries "." and ".." are excluded.
     *
     * Returned paths should be absolute or consistently relative,
     * depending on the implementation.
     *
     * @return list<string>
     *
     * @throws FileSystemException
     */
    public function listDirectory(string $path): array;

    /**
     * Deletes a filesystem entry.
     *
     * If the path refers to a file, the file is deleted.
     *
     * If the path refers to an empty directory, the directory is deleted.
     *
     * If the directory contains files or subdirectories,
     * an exception is thrown.
     *
     * @throws FileSystemException
     */
    public function delete(string $path): void;

    /**
     * Deletes the specified directory and all descendant files and subdirectories.
     *
     * @throws FileSystemException
     */
    public function deleteRecursively(string $path): void;

    /**
     * Returns the file size in bytes.
     *
     * @throws FileSystemException
     */
    public function size(string $path): int;

    /**
     * Returns the last modification timestamp.
     *
     * @throws FileSystemException
     */
    public function lastModified(string $path): int;

    /**
     * Returns the normalized absolute path.
     */
    public function normalizePath(string $path): string;
}
