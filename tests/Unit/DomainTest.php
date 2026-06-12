<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class DomainModelTest extends TestCase
{
    public function test_domain_model_can_be_instantiated(): void
    {
        $domain = new Domain;

        Assert::assertInstanceOf(Domain::class, $domain);
    }

    public function test_get_rows_method_works_correctly(): void
    {
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
    }
}
