<?php

namespace Sammyjo20\Saloon\Traits;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as GuzzleClient;
use Sammyjo20\Saloon\Exceptions\NoMockedRequestsFoundException;
use Sammyjo20\Saloon\Exceptions\SaloonInvalidHandlerException;
use Sammyjo20\Saloon\Exceptions\SaloonDuplicateHandlerException;
use Sammyjo20\Saloon\Laravel\Helpers\LaravelExistenceHelper;
use Sammyjo20\Saloon\Laravel\Http\Handlers\SaloonMockHandler;
use Sammyjo20\Saloon\Laravel\Managers\SaloonMockManager;

trait ManagesGuzzle
{
    /**
     * The list of booted handlers
     *
     * @var array
     */
    private array $bootedHandlers = [];

    /**
     * Create a new Guzzle client
     *
     * @return GuzzleClient
     * @throws SaloonDuplicateHandlerException
     * @throws SaloonInvalidHandlerException
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonMissingMockException
     */
    private function createGuzzleClient(): GuzzleClient
    {
        $clientConfig = [
            'base_uri' => rtrim($this->connector->defineBaseUrl(), '/ ') . '/',
        ];

        if ($this->isMocking === true) {
            $clientConfig['handler'] = HandlerStack::create($this->createMockHandler());
        } else {
            $clientConfig['handler'] = $this->bootHandlers(HandlerStack::create());
        }

        return new GuzzleClient($clientConfig);
    }

    /**
     * Create a "mock" handler so Guzzle can pretend it's a real request.
     *
     * @return MockHandler
     * @throws \Sammyjo20\Saloon\Exceptions\SaloonMissingMockException
     */
    private function createMockHandler(): MockHandler
    {
        $saloonMock = $this->mockType === 'success'
            ? $this->request->getSuccessMock()
            : $this->request->getFailureMock();

        return new MockHandler([
            new Response($saloonMock->getStatusCode(), $saloonMock->getHeaders(), $saloonMock->getBody()),
        ]);
    }

    /**
     * Boot each of the handlers
     *
     * @param HandlerStack $handlerStack
     * @return HandlerStack
     * @throws SaloonDuplicateHandlerException
     * @throws SaloonInvalidHandlerException
     */
    private function bootHandlers(HandlerStack $handlerStack): HandlerStack
    {
        foreach ($this->getHandlers() as $handler => $handlerClosure) {
            if (empty($handler) || empty($handlerClosure)) {
                continue;
            }

            // Let's make sure the handler isn't already added to the list of handlers
            // if it is - this is bad, so we should throw an exception.

            if (in_array($handler, $this->bootedHandlers, false)) {
                throw new SaloonDuplicateHandlerException($handler);
            }

            // Once that's all good, push the handler onto the stack.

            $handlerStack->push($handlerClosure, $handler);

            // Add the booted handler here, so it can't be loaded again.

            $this->bootedHandlers[] = $handler;
        }

        // Now let's boot the mocking handler. Most of the time it will be disabled, but
        // we need to check here in case it has been enabled by Laravel.

        $handlerStack = $this->bootMockingHandler($handlerStack);

        return $handlerStack;
    }

    /**
     * Boot up the mocking handler if Saloon is being used in Laravel, and if
     * mocking is enabled.
     *
     * @param HandlerStack $handlerStack
     * @return HandlerStack
     * @throws NoMockedRequestsFoundException
     */
    private function bootMockingHandler(HandlerStack $handlerStack): HandlerStack
    {
        if (LaravelExistenceHelper::check() === false) {
            return $handlerStack;
        }

        $mockManager = SaloonMockManager::resolve();
        $isMocking = $mockManager->isMocking();

        if ($isMocking === false) {
            return $handlerStack;
        }

        if ($mockManager->doesntHaveQueuedRequests()) {
            throw new NoMockedRequestsFoundException;
        }

        // Todo: Use wildcard requests AND sequence requests.

        $handlerStack->push(new SaloonMockHandler($mockManager->pullNextRequest()), 'saloonMockHandler');

        return $handlerStack;
    }
}
