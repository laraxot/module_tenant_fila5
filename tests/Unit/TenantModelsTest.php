<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< .merge_file_Xzc0CR
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
=======
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
>>>>>>> .merge_file_8MAYuD
use Webmozart\Assert\Assert as WebmozartAssert;

uses(TestCase::class);

<<<<<<< .merge_file_Xzc0CR
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
=======
it('can create a tenant', function (): void {
    $tenant = createTenant([
>>>>>>> .merge_file_8MAYuD
        'name' => 'Test Company',
        'domain' => 'test.company.com',
        'database' => 'tenant_test_db',
    ]);

<<<<<<< .merge_file_Xzc0CR
<<<<<<< HEAD
    Assert::assertInstanceOf(Tenant::class, $tenant);
    Assert::assertSame('Test Company', $tenant->name);
    Assert::assertSame('test.company.com', $tenant->domain);
    Assert::assertSame('tenant_test_db', $tenant->database);
=======
    expect($tenant->name)->toBe('Test Company');
    expect($tenant->domain)->toBe('test.company.com');
    expect($tenant->database)->toBe('tenant_test_db');
>>>>>>> .merge_file_8MAYuD
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
<<<<<<< .merge_file_Xzc0CR
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
=======
    $tenant = createTenant([
>>>>>>> .merge_file_8MAYuD
        'name' => 'User Tenant',
        'domain' => 'user.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
<<<<<<< .merge_file_Xzc0CR
<<<<<<< HEAD
    $user = $userFactory->create([
=======
    $user = $userFactory->createOne([
>>>>>>> .merge_file_8MAYuD
        'name' => 'Tenant User',
        'email' => 'user@tenant.example.com',
    ]);
    WebmozartAssert::isInstanceOf($user, User::class);

    $tenant->users()->save($user);

    expect($tenant->users()->whereKey($user->id)->exists())->toBeTrue();
});

it('can create multiple users for a tenant', function (): void {
<<<<<<< .merge_file_Xzc0CR
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
=======
    $tenant = createTenant([
>>>>>>> .merge_file_8MAYuD
        'name' => 'Multi User Tenant',
        'domain' => 'multi.example.com',
    ]);

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $users = $userFactory->count(3)->create();
    foreach ($users->all() as $user) {
        $tenant->users()->save($user);
    }

<<<<<<< .merge_file_Xzc0CR
<<<<<<< HEAD
    Assert::assertSame(3, $tenant->users()->count());
=======
    expect($tenant->users()->count())->toBe(3);
>>>>>>> .merge_file_8MAYuD
});

it('reports active state via isActive', function (): void {
    $active = createTenant(['is_active' => true]);
    $inactive = createTenant(['is_active' => false]);

<<<<<<< .merge_file_Xzc0CR
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
=======
    expect($active->isActive())->toBeTrue();
    expect($inactive->isActive())->toBeFalse();
>>>>>>> .merge_file_8MAYuD
});
