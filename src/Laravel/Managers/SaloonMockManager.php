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
    protected array $queuedRequests = [];

    /**
     * Tell the Saloon Mock Manager to start mocking
     *
     * @return $this
     */
    public function startMocking(array $requests): self
    {
        $this->isActive = true;

        $this->recordRequests($requests);

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
     * Record the incoming requests
     *
     * @param array $requests
     * @return $this
     */
    private function recordRequests(array $requests): self
    {
        // Todo: Add better logic here...

        $this->queuedRequests = $requests;

        return $this;
    }

    /**
     * Get all the queued requests
     *
     * @return array
     */
    public function getQueuedRequests(): array
    {
        return $this->queuedRequests;
    }

    /**
     * Check if Saloon doesnt have any queued requests.
     *
     * @return bool
     */
    public function doesntHaveQueuedRequests(): bool
    {
        return empty($this->queuedRequests);
    }

    /**
     * Check if there are queued requests.
     *
     * @return bool
     */
    public function hasQueuedRequests(): bool
    {
        return ! $this->doesntHaveQueuedRequests();
    }

    /**
     * Grab the next request and also delete it from the queue.
     *
     * @return bool
     */
    public function pullNextRequest(): mixed // Todo: Return type
    {
        return array_shift($this->queuedRequests);
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
