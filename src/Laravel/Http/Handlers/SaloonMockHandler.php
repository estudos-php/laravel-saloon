<?php

namespace Sammyjo20\Saloon\Laravel\Http\Handlers;

use Psr\Http\Message\RequestInterface;

class SaloonMockHandler
{
    protected $request; // Todo: Data Type

    public function __construct($request) // Todo: Data type
    {
        $this->request = $request;
    }

    public function __invoke(callable $handler)
    {
        return function (RequestInterface $request, array $options) use ($handler) {
            dd($this->request);

            // dd('Within mock handler...', $this->request);

            return $handler($request, $options);
        };
    }
}
