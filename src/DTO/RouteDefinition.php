<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class RouteDefinition
{
    public function __construct(
        private string $method,
        private string $uri,
        private string $handler,
        private string $framework
    ) {
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getFramework(): string
    {
        return $this->framework;
    }
}