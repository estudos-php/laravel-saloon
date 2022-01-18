<?php

namespace Sammyjo20\Saloon\Laravel\Managers;

class SaloonMockManager
{
    /**
     * Check if the mock manager is active.
     *
     * @var bool
     */
    protected bool $isActive = false;

    /**
     * The responses that will be replaced by real requests
     *
     * @var array
     */
    protected array $responseQueue = [];

    /**
     * Tell the Saloon Mock Manager to start mocking
     *
     * @return $this
     */
    public function startMocking(): self
    {
        $this->isActive = true;

        return $this;
    }

    /**
     * Check if the service is being mocked
     *
     * @return bool
     */
    public function isMocking(): bool
    {
        return $this->isActive;
    }

    /**
     * Resolve the mock manager from the service container.
     *
     * @return static
     */
    public static function resolve(): self
    {
        return resolve(static::class);
    }
}
