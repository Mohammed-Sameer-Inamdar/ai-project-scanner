<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

use AIProjectScanner\DTO\RouteDefinition;

final class RouteDiscoveryResult
{
    public function __construct(
        private array $routes = []
    ) {
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    public function addRoute(RouteDefinition $route): void
    {
        $this->routes[] = $route;
    }

    public function hasRoutes(): bool
    {
        return !empty($this->routes);
    }
}