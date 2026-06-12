<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

final class TenantModelsTest extends TestCase
{
    public function test_can_create_a_tenant(): void
    {
        $tenant = TenantFactory::new()->createOne([
            'name' => 'Test Company',
            'domain' => 'test.company.com',
            'database' => 'tenant_test_db',
        ]);

        Assert::assertInstanceOf(Tenant::class, $tenant);
        Assert::assertSame('Test Company', $tenant->name);
        Assert::assertSame('test.company.com', $tenant->domain);
        Assert::assertSame('tenant_test_db', $tenant->database);
    }

    public function test_can_associate_users_with_a_tenant(): void
    {
        $tenant = TenantFactory::new()->createOne([
            'name' => 'User Tenant',
            'domain' => 'user.example.com',
        ]);

        $user = UserFactory::new()->createOne([
            'name' => 'Tenant User',
            'email' => 'user@tenant.example.com',
        ]);

        Assert::assertInstanceOf(User::class, $user);
        $this->assertDatabaseHasRow('tenants', ['id' => $tenant->id, 'name' => 'User Tenant']);
    }

    public function test_can_create_multiple_users_for_one_tenant(): void
    {
        $tenant = TenantFactory::new()->createOne([
            'name' => 'Multi User Tenant',
            'domain' => 'multi.example.com',
        ]);

        $users = UserFactory::new()->count(3)->create();

        Assert::assertInstanceOf(Tenant::class, $tenant);
        Assert::assertCount(3, $users->all());
    }
}
