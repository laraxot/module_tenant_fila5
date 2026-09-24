<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
use Mockery;
use Mockery\Expectation;
=======
use Mockery\MockInterface;
>>>>>>> 1ad0554 (.)
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

<<<<<<< HEAD
afterEach(function (): void {
    Mockery::close();
});

test('domain model can be instantiated', function (): void {
    Assert::assertInstanceOf(Domain::class, new Domain);
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

    $domain = new Domain;
    $rows = $domain->getRows();

    expect($rows)->toHaveCount(2);
    expect($rows[0]['name'])->toBe('test-domain.com');
    expect($rows[1]['name'])->toBe('example.org');
=======
test('domain model can be instantiated', function (): void {
    $domain = new Domain();

    Assert::assertInstanceOf(Domain::class, $domain);
});

test('get rows method works correctly', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
        $mock->allows([
            'execute' => [
                ['id' => 'test-domain.com', 'name' => 'test-domain.com'],
                ['id' => 'example.org', 'name' => 'example.org'],
            ],
        ]);
    });

    $domain = new Domain();
    $rows = $domain->getRows();

    Assert::assertCount(2, $rows);
    Assert::assertSame('test-domain.com', $rows[0]['name']);
    Assert::assertSame('example.org', $rows[1]['name']);
>>>>>>> 1ad0554 (.)
});
