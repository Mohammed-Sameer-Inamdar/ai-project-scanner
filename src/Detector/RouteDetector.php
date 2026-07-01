<?php

declare(strict_types=1);

namespace AIProjectScanner\Detector;

use AIProjectScanner\Contracts\FileSystemInterface;
use AIProjectScanner\DTO\FileNode;
use AIProjectScanner\DTO\RouteDefinition;
use AIProjectScanner\DTO\RouteDiscoveryResult;
use AIProjectScanner\DTO\ScanResult;

final class RouteDetector
{
    private const CI4_DIRECT_METHODS = [
        'add',
        'get',
        'post',
        'put',
        'head',
        'options',
        'delete',
        'patch',
    ];

    public function __construct(
        private readonly FileSystemInterface $fileSystem
    ) {}

    public function detect(
        ScanResult $scanResult,
        string $projectRoot
    ): RouteDiscoveryResult {
        $result = new RouteDiscoveryResult();

        $this->detectCodeIgniterRoutes(
            $scanResult,
            $projectRoot,
            $result
        );

        $this->detectLaravelRoutes($scanResult, $projectRoot, $result);

        return $result;
    }

    private function detectCodeIgniterRoutes(
        ScanResult $scanResult,
        string $projectRoot,
        RouteDiscoveryResult $result
    ): void {
        foreach ($scanResult->getFiles() as $file) {
            if (!$file instanceof FileNode) {
                continue;
            }

            if ($file->getPath() !== 'app/Config/Routes.php') {
                continue;
            }

            $routesPath = $projectRoot . DIRECTORY_SEPARATOR . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $file->getPath()
            );

            $content = $this->fileSystem->read($routesPath);

            $rootContent = $this->removeGroups($content);

            $this->extractDirectRoutes($rootContent, $result);
            $this->extractMatchRoutes($rootContent, $result);
            $this->extractGroupedRoutes($content, $result);
        }
    }

    private function extractDirectRoutes(
        string $content,
        RouteDiscoveryResult $result,
        string $prefix = ''
    ): void {
        foreach (self::CI4_DIRECT_METHODS as $method) {
            $pattern = sprintf(
                '/\$[A-Za-z_][A-Za-z0-9_]*->%s\(\s*[\'"]([^\'"]*)[\'"]\s*,\s*(.+?)(?:,\s*\[.*?\])?\s*\);/is',
                preg_quote($method, '/')
            );

            preg_match_all(
                $pattern,
                $content,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
                $uri = $this->joinUri($prefix, $match[1]);
                $handler = $this->normalizeHandler($match[2]);

                if ($handler === '') {
                    continue;
                }

                $result->addRoute(
                    new RouteDefinition(
                        method: $method === 'add' ? 'ANY' : strtoupper($method),
                        uri: $uri,
                        handler: $handler,
                        framework: 'CodeIgniter4'
                    )
                );
            }
        }
    }

    private function extractGroupedRoutes(
        string $content,
        RouteDiscoveryResult $result,
        string $parentPrefix = ''
    ): void {
        $groups = $this->findGroups($content);

        foreach ($groups as $group) {
            $prefix = $this->joinUri($parentPrefix, $group['prefix']);

            $groupDirectContent = $this->removeGroups($group['body']);

            $this->extractDirectRoutes(
                $groupDirectContent,
                $result,
                $prefix
            );

            $this->extractMatchRoutes(
                $groupDirectContent,
                $result,
                $prefix
            );

            $this->extractGroupedRoutes(
                $group['body'],
                $result,
                $prefix
            );
        }
    }

    private function extractMatchRoutes(
        string $content,
        RouteDiscoveryResult $result,
        string $prefix = ''
    ): void {
        preg_match_all(
            '/\$[A-Za-z_][A-Za-z0-9_]*->match\(\s*\[([^\]]+)\]\s*,\s*[\'"]([^\'"]*)[\'"]\s*,\s*(.+?)(?:,\s*\[.*?\])?\s*\);/is',
            $content,
            $matches,
            PREG_SET_ORDER
        );

        foreach ($matches as $match) {
            preg_match_all(
                '/[\'"]([A-Za-z]+)[\'"]/',
                $match[1],
                $methodMatches
            );

            $uri = $this->joinUri($prefix, $match[2]);
            $handler = $this->normalizeHandler($match[3]);

            if ($handler === '') {
                continue;
            }

            foreach ($methodMatches[1] as $httpMethod) {
                $result->addRoute(
                    new RouteDefinition(
                        method: strtoupper($httpMethod),
                        uri: $uri,
                        handler: $handler,
                        framework: 'CodeIgniter4'
                    )
                );
            }
        }
    }

    /**
     * @return array<int, array{prefix: string, body: string, full: string}>
     */
    private function findGroups(string $content): array
    {
        $groups = [];
        $offset = 0;

        while (
            preg_match(
                '/\$[A-Za-z_][A-Za-z0-9_]*->group\(\s*[\'"]([^\'"]+)[\'"]/i',
                $content,
                $match,
                PREG_OFFSET_CAPTURE,
                $offset
            )
        ) {
            $prefix = $match[1][0];
            $startPosition = +$match[0][1];

            $functionPosition = strpos($content, 'function', $startPosition);

            if ($functionPosition === false) {
                break;
            }

            $openingBracePosition = strpos($content, '{', $functionPosition);

            if ($openingBracePosition === false) {
                break;
            }

            $closingBracePosition = $this->findMatchingBrace(
                $content,
                $openingBracePosition
            );

            if ($closingBracePosition === null) {
                break;
            }

            $body = substr(
                $content,
                $openingBracePosition + 1,
                $closingBracePosition - $openingBracePosition - 1
            );

            $full = substr(
                $content,
                $startPosition,
                $closingBracePosition - $startPosition + 3
            );

            $groups[] = [
                'prefix' => $prefix,
                'body' => $body,
                'full' => $full,
            ];

            $offset = $closingBracePosition + 1;
        }

        return $groups;
    }

    private function findMatchingBrace(
        string $content,
        int $openingBracePosition
    ): ?int {
        $depth = 0;
        $length = strlen($content);

        for ($index = $openingBracePosition; $index < $length; $index++) {
            if ($content[$index] === '{') {
                $depth++;
            }

            if ($content[$index] === '}') {
                $depth--;

                if ($depth === 0) {
                    return $index;
                }
            }
        }

        return null;
    }

    private function normalizeHandler(string $handler): string
    {
        $handler = trim($handler);

        if (
            preg_match(
                '/\[\s*([A-Za-z0-9_\\\\]+)::class\s*,\s*[\'"]([^\'"]+)[\'"]\s*\]/',
                $handler,
                $match
            )
        ) {
            return $match[1] . '::' . $match[2];
        }

        if (
            preg_match(
                '/[\'"]([^\'"]+)[\'"]/',
                $handler,
                $match
            )
        ) {
            return $match[1];
        }

        return '';
    }

    private function joinUri(string $prefix, string $uri): string
    {
        $prefix = trim($prefix, '/');
        $uri = trim($uri, '/');

        if ($prefix === '') {
            return $uri === '' ? '/' : $uri;
        }

        if ($uri === '') {
            return $prefix;
        }

        return $prefix . '/' . $uri;
    }

    private function removeGroups(string $content): string
    {
        foreach ($this->findGroups($content) as $group) {
            $content = str_replace($group['full'], '', $content);
        }

        return $content;
    }

    private function detectLaravelRoutes(
        ScanResult $scanResult,
        string $projectRoot,
        RouteDiscoveryResult $result
    ): void {
        foreach ($scanResult->getFiles() as $file) {
            if (!$file instanceof FileNode) {
                continue;
            }

            if (!in_array($file->getPath(), ['routes/web.php', 'routes/api.php'], true)) {
                continue;
            }

            $routesPath = $projectRoot . DIRECTORY_SEPARATOR . str_replace(
                '/',
                DIRECTORY_SEPARATOR,
                $file->getPath()
            );

            $content = $this->fileSystem->read($routesPath);

            $this->extractLaravelDirectRoutes(
                $content,
                $result,
                $file->getPath() === 'routes/api.php' ? 'api' : ''
            );
        }
    }

    private function extractLaravelDirectRoutes(
        string $content,
        RouteDiscoveryResult $result,
        string $prefix = ''
    ): void {
        foreach (self::CI4_DIRECT_METHODS as $method) {
            if ($method === 'add') {
                continue;
            }

            $pattern = sprintf(
                '/Route::%s\(\s*[\'"]([^\'"]*)[\'"]\s*,\s*(.+?)(?:,\s*\[.*?\])?\s*\);/is',
                preg_quote($method, '/')
            );

            preg_match_all(
                $pattern,
                $content,
                $matches,
                PREG_SET_ORDER
            );

            foreach ($matches as $match) {
                $handler = $this->normalizeLaravelHandler($match[2]);

                if ($handler === '') {
                    continue;
                }

                $result->addRoute(
                    new RouteDefinition(
                        method: strtoupper($method),
                        uri: $this->joinUri($prefix, $match[1]),
                        handler: $handler,
                        framework: 'Laravel'
                    )
                );
            }
        }
    }

    private function normalizeLaravelHandler(string $handler): string
    {
        $handler = trim($handler);

        if (
            preg_match(
                '/\[\s*([A-Za-z0-9_\\\\]+)::class\s*,\s*[\'"]([^\'"]+)[\'"]\s*\]/',
                $handler,
                $match
            )
        ) {
            return $match[1] . '@' . $match[2];
        }

        if (
            preg_match(
                '/[\'"]([^\'"]+@[^\'"]+)[\'"]/',
                $handler,
                $match
            )
        ) {
            return $match[1];
        }

        if (
            preg_match(
                '/[A-Za-z0-9_\\\\]+::class/',
                $handler
            )
        ) {
            return trim($handler);
        }

        return '';
    }
}
