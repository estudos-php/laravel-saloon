<?php

namespace Sammyjo20\Saloon\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Sammyjo20\Saloon\Laravel\Saloon fake(array|null $requests = [])
 *
 * @see \Sammyjo20\Saloon\Laravel\Saloon
 */
class Saloon extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'saloon';
    }
}
