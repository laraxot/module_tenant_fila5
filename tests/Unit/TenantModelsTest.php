<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Tenant\Database\Factories\TenantFactory;
=======
>>>>>>> 1ad0554 (.)
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
<<<<<<< HEAD
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;
=======
>>>>>>> 1ad0554 (.)
use Webmozart\Assert\Assert as WebmozartAssert;

uses(TestCase::class);

<<<<<<< HEAD
beforeEach(function (): void {
    /** @var TestCase $this */
    if (TestCase::tenantDbUnavailable()) {
        $this->skipTest('DB `tenant` non raggiungibile: blocco di ambiente.');
    }
});

it('can create a tenant', function (): void {
    $tenant = TestCase::createTenant([
=======
it('can create a tenant', function (): void {
    $tenant = createTenant([
>>>>>>> 1ad0554 (.)
        'name' => 'Test Company',
        'domain' => 'test.company.com',
        'database' => 'tenant_test_db',
    ]);

<<<<<<< HEAD
    Assert::assertInstanceOf(Tenant::class, $tenant);
    Assert::assertSame('Test Company', $tenant->name);
    Assert::assertSame('test.company.com', $tenant->domain);
    Assert::assertSame('tenant_test_db', $tenant->database);
});

it('can create a tenant with settings', function (): void {
    /** @var TestCase $this */
    try {
        $schema = DB::connection('tenant')->getSchemaBuilder();
        if (! $schema->hasColumn('tenants', 'settings')) {
            $this->skipTest('Colonna tenants.settings assente sullo schema condiviso.');
        }
    } catch (\Throwable) {
        $this->skipTest('Schema tenant non ispezionabile.');
    }

    /** @var TenantFactory $factory */
    $factory = Tenant::factory();
    $tenant = $factory->withSettings(['locale' => 'it', 'timezone' => 'Europe/Rome'])->create([
        'name' => 'Settings Tenant',
        'domain' => 'settings.example.com',
    ]);
    WebmozartAssert::isInstanceOf($tenant, Tenant::class);

    Assert::assertIsArray($tenant->settings);
    Assert::assertSame('it', $tenant->settings['locale'] ?? null);
});

it('exposes users relationship', function (): void {
    $tenant = TestCase::createTenant([
=======
    expect($tenant)->toBeInstanceOf(Tenant::class);
    expect($tenant->name)->toBe('Test Company');
    expect($tenant->domain)->toBe('test.company.com');
    expect($tenant->database)->toBe('tenant_test_db');
});

it('can create a tenant with settings', function (): void {
    $tenant = createTenant([
        'name' => 'Settings Tenant',
        'domain' => 'settings.example.com',
        'settings' => ['locale' => 'it', 'timezone' => 'Europe/Rome'],
    ]);

    expect($tenant->settings)->toBeArray();
    expect($tenant->settings['locale'] ?? null)->toBe('it');
});

it('exposes users relationship', function (): void {
    $tenant = createTenant([
>>>>>>> 1ad0554 (.)
        'name' => 'User Tenant',
        'domain' => 'user.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
<<<<<<< HEAD
    $user = $userFactory->create([
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);
    WebmozartAssert::isInstanceOf($user, UserContract::class);
    WebmozartAssert::isInstanceOf($user, Model::class);

    $tenant->users()->save($user);

    Assert::assertTrue($tenant->users()->whereKey($user->id)->exists());
});

it('can create multiple users for a tenant', function (): void {
    $tenant = TestCase::createTenant([
=======
    $user = $userFactory->createOne([
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);
    WebmozartAssert::isInstanceOf($user, User::class);

    $tenant->users()->save($user);

    expect($tenant->users()->whereKey($user->id)->exists())->toBeTrue();
});

it('can create multiple users for a tenant', function (): void {
    $tenant = createTenant([
>>>>>>> 1ad0554 (.)
        'name' => 'Multi User Tenant',
        'domain' => 'multi.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $users = $userFactory->count(3)->create();
    foreach ($users->all() as $user) {
        $tenant->users()->save($user);
    }

<<<<<<< HEAD
    Assert::assertSame(3, $tenant->users()->count());
});

it('reports active state via isActive', function (): void {
    $active = TestCase::createTenant(['is_active' => true]);
    $inactive = TestCase::createTenant(['is_active' => false]);

    Assert::assertTrue($active->isActive());
    Assert::assertFalse($inactive->isActive());
=======
    expect($tenant->users()->count())->toBe(3);
});

it('reports active state via isActive', function (): void {
    $active = createTenant(['is_active' => true]);
    $inactive = createTenant(['is_active' => false]);

    expect($active->isActive())->toBeTrue();
    expect($inactive->isActive())->toBeFalse();
>>>>>>> 1ad0554 (.)
});
