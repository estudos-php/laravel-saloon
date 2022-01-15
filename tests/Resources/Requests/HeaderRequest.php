<?php

namespace Sammyjo20\Saloon\Tests\Resources\Requests;

use Sammyjo20\Saloon\Constants\Saloon;
use Sammyjo20\Saloon\Http\SaloonRequest;
use Sammyjo20\Saloon\Tests\Resources\Connectors\HeaderConnector;
use Sammyjo20\Saloon\Tests\Resources\Connectors\TestConnector;
use Sammyjo20\Saloon\Traits\Features\HasJsonBody;

class HeaderRequest extends SaloonRequest
{
    use HasJsonBody;

    /**
     * Define the method that the request will use.
     *
     * @var string|null
     */
    protected ?string $method = Saloon::GET;

    /**
     * The connector.
     *
     * @var string|null
     */
    protected ?string $connector = HeaderConnector::class;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function defineEndpoint(): string
    {
        return '/user';
    }

    public function defaultHeaders(): array
    {
        return [
            'X-Custom-Header' => 'Howdy'
        ];
    }

    public function defaultConfig(): array
    {
        return [
            'timeout' => 5,
        ];
    }

    public function defaultData(): array
    {
        return [
            'foo' => 'bar'
        ];
    }
}


