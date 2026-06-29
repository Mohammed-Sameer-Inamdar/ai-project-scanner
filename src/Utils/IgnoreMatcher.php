<?php

declare(strict_types=1);

namespace AIProjectScanner\Utils;

final class IgnoreMatcher
{
    public function shouldIgnore(
        string $path,
        array $patterns
    ): bool {
        $normalizedPath = str_replace('\\', '/', $path);

        foreach ($patterns as $pattern) {
            $normalizedPattern = trim(str_replace('\\', '/', (string) $pattern));

            if ($normalizedPattern === '') {
                continue;
            }

            if ($this->matches($normalizedPath, $normalizedPattern)) {
                return true;
            }
        }

        return false;
    }

    private function matches(string $path, string $pattern): bool
    {
        $pattern = ltrim($pattern, '/');

        if (str_ends_with($pattern, '/')) {
            $directory = rtrim($pattern, '/');

            return $path === $directory
                || str_starts_with($path, $directory . '/')
                || str_contains($path, '/' . $directory . '/')
                || str_ends_with($path, '/' . $directory);
        }

        return fnmatch($pattern, $path)
            || fnmatch($pattern, basename($path))
            || str_contains($path, '/' . $pattern . '/');
    }
}
