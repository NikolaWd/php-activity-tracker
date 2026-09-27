<?php

declare(strict_types=1);

namespace App\Core;

class Route
{
    private ?string $name = null;
    private array $middlewares = [];

    public function __construct(
        private string $path, private array $handler
    ){}

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function middleware(array $middlewares): self
    {
        foreach ($middlewares as $middleware) {
            if (!$middleware instanceof Middleware) {
                throw new \InvalidArgumentException('Middleware must implement ' . Middleware::class);
            }

            $this->middlewares[] = $middleware;
        }

        return $this;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
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
