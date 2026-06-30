<?php

declare(strict_types=1);

namespace AIProjectScanner\DTO;

final class ModuleDiscoveryResult
{
    /**
     * @param array<Module> $modules
     */
    public function __construct(
        private readonly array $modules
    ) {
    }

    /**
     * @return array<Module>
     */
    public function getModules(): array
    {
        return $this->modules;
    }
}