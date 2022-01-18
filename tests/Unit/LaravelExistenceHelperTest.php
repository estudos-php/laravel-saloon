<?php

use Sammyjo20\Saloon\Laravel\Helpers\LaravelExistenceHelper;

test('it cant detect laravel environment', function () {
    $exists = LaravelExistenceHelper::check();

    expect($exists)->toBeFalse();
});
