<?php

use Sammyjo20\Saloon\Laravel\Facades\Saloon;
use Sammyjo20\Saloon\Tests\Resources\Requests\UserRequest;

test('it can return a fake response when mocking', function () {
    Saloon::fake([
        new FakeSaloonRequest(),
    ]);

    $response = (new UserRequest())->send();

    dd($response);
});

test('you can disable a handler so it wont be loaded when mocking', function () {
    //
});

test('you can disable a response interceptor so it wont be loaded when mocking', function () {
    //
});

test('you can disable a plugin so it wont be loaded when mocking', function () {
    //
});
