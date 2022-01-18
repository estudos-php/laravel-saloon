<?php


use Sammyjo20\Saloon\Exceptions\NoMockedRequestsFoundException;
use Sammyjo20\Saloon\Laravel\Facades\Saloon;
use Sammyjo20\Saloon\Laravel\Managers\SaloonMockManager;
use Sammyjo20\Saloon\Tests\Resources\Requests\UserRequest;

test('the saloon mock manager is not set to testing mode when mocking is not used', function () {
    $mockManager = SaloonMockManager::resolve();

    expect($mockManager->isMocking())->toBeFalse();
});

test('the saloon mock manager is set to testing mode when mocking is used', function () {
    Saloon::fake();

    $mockManager = SaloonMockManager::resolve();

    expect($mockManager->isMocking())->toBeTrue();
});

it('throws an exception if there are no fake requests', function () {
    Saloon::fake();

    $request = new UserRequest;

    $this->expectException(NoMockedRequestsFoundException::class);

    $request->send();
});
