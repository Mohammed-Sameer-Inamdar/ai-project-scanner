<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class RouteDiscoveryResult
{
    /**
     * @var array<RouteDefinition>
     */
    private array $routes = [];

    /**
     * @var array<string, bool>
     */
    private array $routeKeys = [];

    /**
     * @return array<RouteDefinition>
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(RouteDefinition $route): void
    {
        $key = $this->buildRouteKey($route);

        if (isset($this->routeKeys[$key])) {
            return;
        }

        $this->routeKeys[$key] = true;
        $this->routes[] = $route;
    }

    public function hasRoutes(): bool
    {
        return $this->routes !== [];
    }

    public function count(): int
    {
        return count($this->routes);
    }

    /**
     * @return array<string, int>
     */
    public function countByFramework(): array
    {
        $counts = [];

        foreach ($this->routes as $route) {
            $framework = $route->getFramework();
            $counts[$framework] = ($counts[$framework] ?? 0) + 1;
        }

        ksort($counts);

        return $counts;
    }

    private function buildRouteKey(RouteDefinition $route): string
    {
        return implode('|', [
            strtoupper($route->getMethod()),
            trim($route->getUri(), '/'),
            $route->getHandler(),
            $route->getFramework(),
        ]);
    }
}