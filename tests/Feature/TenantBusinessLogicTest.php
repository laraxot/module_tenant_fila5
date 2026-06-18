<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Modules\Tenant\Database\Factories\TenantDomainFactory;
use Modules\Tenant\Database\Factories\TenantSettingFactory;
use Modules\Tenant\Database\Factories\TenantSubscriptionFactory;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Models\TenantSetting;
use Modules\Tenant\Models\TenantSubscription;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use Webmozart\Assert\Assert as WebmozartAssert;

uses(TestCase::class);

it('creates and persists tenant records', function (): void {
    /** @var TestCase $this */
    $tenant = createTenant([
        'name' => 'Test Studio',
        'slug' => 'test-studio',
        'is_active' => true,
    ]);

    $this->assertDatabaseHasRow('tenants', [
        'id' => $tenant->id,
        'name' => 'Test Studio',
        'slug' => 'test-studio',
    ]);
});

it('creates tenant domain records', function (): void {
    /** @var TestCase $this */
    $tenant = createTenant();

    /** @var TenantDomainFactory $factory */
    $factory = TenantDomain::factory();
    $domain = $factory->createOne([
        'tenant_id' => $tenant->id,
        'domain' => 'test.example.com',
        'is_primary' => true,
        'status' => 'active',
    ]);

    Assert::assertInstanceOf(TenantDomain::class, $domain);
    $this->assertDatabaseHasRow('tenant_domains', [
        'id' => $domain->id,
        'tenant_id' => $tenant->id,
        'domain' => 'test.example.com',
    ]);
});

it('creates tenant settings and subscriptions', function (): void {
    $tenant = createTenant();

    /** @var TenantSettingFactory $settingFactory */
    $settingFactory = TenantSetting::factory();
    $setting = $settingFactory->createOne([
        'tenant_id' => $tenant->id,
        'key' => 'locale',
        'value' => 'it',
        'type' => 'string',
    ]);

    /** @var TenantSubscriptionFactory $subscriptionFactory */
    $subscriptionFactory = TenantSubscription::factory();
    $subscription = $subscriptionFactory->createOne([
        'tenant_id' => $tenant->id,
        'plan_name' => 'basic',
        'status' => 'active',
    ]);

    Assert::assertInstanceOf(TenantSetting::class, $setting);
    Assert::assertInstanceOf(TenantSubscription::class, $subscription);
    Assert::assertSame('locale', $setting->key);
    Assert::assertSame('basic', $subscription->plan_name);
});

it('associates users with tenant', function (): void {
    $tenant = createTenant();

    /** @var UserFactory $userFactory */
    $userFactory = User::factory();
    $user = $userFactory->createOne(['tenant_id' => $tenant->id]);
    Assert::assertInstanceOf(User::class, $user);

    Assert::assertTrue($tenant->users()->where('users.id', $user->id)->exists());
});
