<?php

namespace Sammyjo20\Saloon\Laravel;

use Carbon\Laravel\ServiceProvider;
use Sammyjo20\Saloon\Laravel\Managers\SaloonMockManager;

class SaloonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind('saloon', fn () => new Saloon);
        $this->app->singleton(SaloonMockManager::class, fn () => new SaloonMockManager);
    }
}
