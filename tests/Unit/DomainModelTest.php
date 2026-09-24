<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
use Mockery\MockInterface;
=======
>>>>>>> 1ad0554 (.)
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
uses(TestCase::class);

describe('Domain Model', function (): void {
    test('_domain_model_can_be_instantiated', function (): void {
        $domain = new Domain;
=======
uses(\Modules\Tenant\Tests\TestCase::class);

describe('Domain Model', function (): void {
    test('_domain_model_can_be_instantiated', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$domain = new Domain;
>>>>>>> 1ad0554 (.)

        Assert::assertInstanceOf(Domain::class, $domain);
    });

    test('_get_rows_method_works_correctly', function (): void {
<<<<<<< HEAD
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
=======
$this->mockService(GetDomainsArrayAction::class, function ($mock): void {
>>>>>>> 1ad0554 (.)
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
});
