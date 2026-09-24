<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Mockery\MockInterface;
use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_2cPpKW
uses(TestCase::class);

describe('Domain Model', function (): void {
    test('_domain_model_can_be_instantiated', function (): void {
        $domain = new Domain;
=======
uses(\Modules\Tenant\Tests\TestCase::class);

describe('Domain Model', function (): void {
    test('_domain_model_can_be_instantiated', function (): void {
        $domain = new Domain();
>>>>>>> .merge_file_Aa0cRN

        Assert::assertInstanceOf(Domain::class, $domain);
    });

    test('_get_rows_method_works_correctly', function (): void {
        TestCase::mockAppService(GetDomainsArrayAction::class, static function (MockInterface $mock): void {
            $mock->allows([
                'execute' => [
                    ['id' => 1, 'name' => 'test-domain.com'],
                    ['id' => 2, 'name' => 'example.org'],
                ],
            ]);
        });

<<<<<<< .merge_file_2cPpKW
        $domain = new Domain;
=======
        $domain = new Domain();
>>>>>>> .merge_file_Aa0cRN
        $rows = $domain->getRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame('test-domain.com', $rows[0]['name']);
        Assert::assertSame('example.org', $rows[1]['name']);
    });
});
