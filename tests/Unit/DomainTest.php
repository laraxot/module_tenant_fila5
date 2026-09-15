<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery;
use Mockery\Expectation;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
uses(TestCase::class);
=======
uses(\Modules\Tenant\Tests\TestCase::class);
>>>>>>> laraxot/dev

afterEach(function (): void {
    Mockery::close();
});

test('domain model can be instantiated', function (): void {
<<<<<<< HEAD
    Assert::assertInstanceOf(Domain::class, new Domain);
=======
    Assert::assertInstanceOf(Domain::class, new Domain());
>>>>>>> laraxot/dev
});

test('get rows method works correctly', function (): void {
    $mock = Mockery::mock(GetDomainsArrayAction::class);
    $expectation = $mock->shouldReceive('execute');
    assert($expectation instanceof Expectation);
    $expectation->andReturn([
        ['id' => 1, 'name' => 'test-domain.com'],
        ['id' => 2, 'name' => 'example.org'],
    ]);

    app()->instance(GetDomainsArrayAction::class, $mock);

<<<<<<< HEAD
    $domain = new Domain;
=======
    $domain = new Domain();
>>>>>>> laraxot/dev
    $rows = $domain->getRows();

    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
});
