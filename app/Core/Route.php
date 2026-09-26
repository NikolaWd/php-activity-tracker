<?php

declare(strict_types=1);

namespace App\Core;

class Route
{
    private ?string $name = null;

    public function __construct(
        private string $path, private array $handler
    ){}

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHandler(): array
    {
        return $this->handler;
    }   
    
    public function getName(): ?string
    {
        return $this->name;
    }
}