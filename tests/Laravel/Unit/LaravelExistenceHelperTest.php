<?php

use Sammyjo20\Saloon\Laravel\Helpers\LaravelExistenceHelper;

test('it can detect laravel environment', function () {
    $exists = LaravelExistenceHelper::check();

    expect($exists)->toBeTrue();
});
