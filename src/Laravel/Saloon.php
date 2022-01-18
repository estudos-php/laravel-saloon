<?php

namespace Sammyjo20\Saloon\Laravel;

use Sammyjo20\Saloon\Laravel\Managers\SaloonMockManager;

class Saloon
{
    /**
     * Boot up the mock manager.
     *
     * @return void
     */
    public static function fake(array $requests = [])
    {
        SaloonMockManager::resolve()->startMocking($requests);
    }
}
