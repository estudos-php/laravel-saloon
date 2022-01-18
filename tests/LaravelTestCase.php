<?php

namespace Sammyjo20\Saloon\Tests;

use \Orchestra\Testbench\TestCase as TestBench;
use Sammyjo20\Saloon\Laravel\SaloonServiceProvider;

class LaravelTestCase extends TestBench
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            SaloonServiceProvider::class,
        ];
    }
}
