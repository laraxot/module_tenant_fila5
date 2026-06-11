<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('domain model can be instantiated', function (): void {
    /** @var TestCase $this */
    $domain = new Domain;

    Assert::assertInstanceOf(Domain::class, $domain);
});

test('get rows method works correctly', function (): void {
    /** @var TestCase $this */
    $this->mockService(GetDomainsArrayAction::class, function ($mock): void {
        $mock->allows([
            'execute' => [
                ['id' => 1, 'name' => 'test-domain.com'],
                ['id' => 2, 'name' => 'example.org'],
            ],
        ]);
    });

    $domain = new Domain;
    $rows = $domain->getRows();

    Assert::assertCount(2, $rows);
    Assert::assertSame('test-domain.com', $rows[0]['name']);
    Assert::assertSame('example.org', $rows[1]['name']);
});
