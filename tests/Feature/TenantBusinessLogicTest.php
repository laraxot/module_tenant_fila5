<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Feature;

use Modules\Tenant\Database\Factories\TenantDomainFactory;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Database\Factories\TenantSettingFactory;
use Modules\Tenant\Database\Factories\TenantSubscriptionFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantDomain;
use Modules\Tenant\Models\TenantSubscription;
use Modules\Tenant\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

describe('Tenant Business Logic', function (): void {
    test('_can_create_and_manage_tenants', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$user = UserFactory::new()->createOne();
        Assert::assertInstanceOf(User::class, $user);

        $tenant = TenantFactory::new()->createOne([
            'name' => 'Test Studio',
            'slug' => 'test-studio',
            'is_active' => true,
        ]);
        Assert::assertInstanceOf(Tenant::class, $tenant);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Studio',
            'slug' => 'test-studio',
        ]);

        Assert::assertSame('Test Studio', $tenant->name);
        Assert::assertSame('test-studio', $tenant->slug);
        Assert::assertTrue($tenant->is_active);
    });

    test('_can_manage_tenant_domains', function (): void {
$tenant = TenantFactory::new()->createOne();
        Assert::assertInstanceOf(Tenant::class, $tenant);

        $domain = TenantDomainFactory::new()->createOne([
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
            'is_primary' => true,
            'status' => 'active',
        ]);

        Assert::assertSame($tenant->id, $domain->tenant_id);
        Assert::assertSame('test.example.com', $domain->domain);
        Assert::assertTrue($domain->is_primary);
        Assert::assertSame('active', $domain->status);
    });

    test('_can_manage_tenant_settings', function (): void {
$tenant = TenantFactory::new()->createOne();

        $setting = TenantSettingFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Test Studio Application',
            'type' => 'string',
        ]);

        $this->assertDatabaseHasRow('tenant_settings', [
            'id' => $setting->id,
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Test Studio Application',
            'type' => 'string',
        ]);

        Assert::assertSame($tenant->id, $setting->tenant_id);
        Assert::assertSame('app.name', $setting->key);
        Assert::assertSame('Test Studio Application', $setting->value);
        Assert::assertSame('string', $setting->type);
    });

    test('_can_manage_tenant_subscriptions', function (): void {
$tenant = TenantFactory::new()->createOne();

        $subscription = TenantSubscriptionFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'plan_name' => 'Professional',
            'status' => 'active',
            'starts_at' => now(),
            'expires_at' => now()->addYear(),
            'max_users' => 50,
            'max_storage_gb' => 100,
        ]);

        $this->assertDatabaseHasRow('tenant_subscriptions', [
            'id' => $subscription->id,
            'tenant_id' => $tenant->id,
            'plan_name' => 'Professional',
            'status' => 'active',
            'max_users' => 50,
            'max_storage_gb' => 100,
        ]);

        Assert::assertSame($tenant->id, $subscription->tenant_id);
        Assert::assertSame('Professional', $subscription->plan_name);
        Assert::assertSame('active', $subscription->status);
        Assert::assertSame(50, $subscription->max_users);
        Assert::assertSame(100, $subscription->max_storage_gb);
    });

    test('_can_validate_tenant_slug_uniqueness', function (): void {
$tenant1 = TenantFactory::new()->createOne([
            'name' => 'Studio A',
            'slug' => 'studio-a',
        ]);
        $tenant2 = TenantFactory::new()->createOne([
            'name' => 'Studio B',
            'slug' => 'studio-b',
        ]);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant1->id,
            'slug' => 'studio-a',
        ]);

        $this->assertDatabaseHasRow('tenants', [
            'id' => $tenant2->id,
            'slug' => 'studio-b',
        ]);

        Assert::assertNotSame($tenant1->slug, $tenant2->slug);
        Assert::assertSame('studio-a', $tenant1->slug);
        Assert::assertSame('studio-b', $tenant2->slug);
    });

    test('_can_manage_tenant_status_workflow', function (): void {
$tenant = TenantFactory::new()->createOne([
            'is_active' => false,
        ]);

        $tenant->update(['is_active' => true]);

        $tenantFresh = $tenant->fresh();
        Assert::assertInstanceOf(Tenant::class, $tenantFresh);
        Assert::assertTrue($tenantFresh->is_active);

        $tenant->update(['is_active' => false]);

        $tenantFresh = $tenant->fresh();
        Assert::assertInstanceOf(Tenant::class, $tenantFresh);
        Assert::assertFalse($tenantFresh->is_active);

        $tenant->update(['is_active' => true]);

        $tenantFresh = $tenant->fresh();
        Assert::assertInstanceOf(Tenant::class, $tenantFresh);
        Assert::assertTrue($tenantFresh->is_active);
    });

    test('_can_handle_tenant_domain_verification', function (): void {
$tenant = TenantFactory::new()->createOne();

        $domain = TenantDomainFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'domain' => 'unverified.example.com',
            'is_primary' => false,
            'status' => 'pending_verification',
            'verification_token' => 'abc123',
        ]);

        $this->assertDatabaseHasRow('tenant_domains', [
            'id' => $domain->id,
            'status' => 'pending_verification',
        ]);

        Assert::assertSame('pending_verification', $domain->status);
        Assert::assertSame('abc123', $domain->verification_token);

        $domain->update([
            'status' => 'active',
            'verified_at' => now(),
            'verification_token' => null,
        ]);

        $domainFresh = $domain->fresh();
        Assert::assertInstanceOf(TenantDomain::class, $domainFresh);
        Assert::assertSame('active', $domainFresh->status);
        Assert::assertNotNull($domainFresh->verified_at);
        Assert::assertNull($domainFresh->verification_token);
    });

    test('_can_manage_tenant_storage_limits', function (): void {
$tenant = TenantFactory::new()->createOne();
        $subscription = TenantSubscriptionFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'max_storage_gb' => 100,
            'current_storage_gb' => 25,
        ]);

        $this->assertDatabaseHasRow('tenant_subscriptions', [
            'id' => $subscription->id,
            'max_storage_gb' => 100,
            'current_storage_gb' => 25,
        ]);

        Assert::assertSame(100, $subscription->max_storage_gb);
        Assert::assertSame(25, $subscription->current_storage_gb);
        Assert::assertSame(75, $subscription->max_storage_gb - $subscription->current_storage_gb);

        $subscription->update(['current_storage_gb' => 50]);

        $subFresh = $subscription->fresh();
        Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
        Assert::assertSame(50, $subFresh->current_storage_gb);
        Assert::assertSame(50, $subFresh->max_storage_gb - $subFresh->current_storage_gb);
    });

    test('_can_manage_tenant_user_limits', function (): void {
$tenant = TenantFactory::new()->createOne();
        $subscription = TenantSubscriptionFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'max_users' => 50,
            'current_users' => 10,
        ]);

        $this->assertDatabaseHasRow('tenant_subscriptions', [
            'id' => $subscription->id,
            'max_users' => 50,
            'current_users' => 10,
        ]);

        Assert::assertSame(50, $subscription->max_users);
        Assert::assertSame(10, $subscription->current_users);
        Assert::assertSame(40, $subscription->max_users - $subscription->current_users);

        $subscription->update(['current_users' => 25]);

        $subFresh = $subscription->fresh();
        Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
        Assert::assertSame(25, $subFresh->current_users);
        Assert::assertSame(25, $subFresh->max_users - $subFresh->current_users);
    });

    test('_can_handle_tenant_subscription_expiration', function (): void {
$tenant = TenantFactory::new()->createOne();
        $subscription = TenantSubscriptionFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'status' => 'active',
            'expires_at' => now()->subDays(1),
        ]);

        $this->assertDatabaseHasRow('tenant_subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);

        Assert::assertNotNull($subscription->expires_at);
        Assert::assertTrue($subscription->expires_at->isPast());

        $subscription->update(['status' => 'expired']);

        $subFresh = $subscription->fresh();
        Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
        Assert::assertSame('expired', $subFresh->status);
    });

    test('_can_manage_tenant_settings_hierarchy', function (): void {
$tenant = TenantFactory::new()->createOne();

        $appSetting = TenantSettingFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'key' => 'app.name',
            'value' => 'Studio App',
            'type' => 'string',
        ]);

        $databaseSetting = TenantSettingFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'key' => 'database.connection',
            'value' => 'mysql',
            'type' => 'string',
        ]);

        $mailSetting = TenantSettingFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'key' => 'mail.driver',
            'value' => 'smtp',
            'type' => 'string',
        ]);

        $this->assertDatabaseHasRow('tenant_settings', [
            'id' => $appSetting->id,
            'key' => 'app.name',
        ]);

        $this->assertDatabaseHasRow('tenant_settings', [
            'id' => $databaseSetting->id,
            'key' => 'database.connection',
        ]);

        $this->assertDatabaseHasRow('tenant_settings', [
            'id' => $mailSetting->id,
            'key' => 'mail.driver',
        ]);

        Assert::assertSame('app.name', $appSetting->key);
        Assert::assertSame('database.connection', $databaseSetting->key);
        Assert::assertSame('mail.driver', $mailSetting->key);
    });

    test('_can_validate_tenant_domain_formats', function (): void {
$tenant = TenantFactory::new()->createOne();

        $validDomains = [
            'example.com',
            'sub.example.com',
            'test-studio.com',
            'studio123.com',
        ];

        foreach ($validDomains as $domain) {
            $tenantDomain = TenantDomainFactory::new()->createOne([
                'tenant_id' => $tenant->id,
                'domain' => $domain,
                'status' => 'active',
            ]);

            Assert::assertSame($domain, $tenantDomain->domain);
            $this->assertDatabaseHasRow('tenant_domains', [
                'id' => $tenantDomain->id,
                'domain' => $domain,
            ]);
        }
    });

    test('_can_track_tenant_activity', function (): void {
$tenant = TenantFactory::new()->createOne([
            'created_at' => now()->subMonths(3),
            'last_activity_at' => now()->subDays(5),
        ]);

        $tenant->update(['last_activity_at' => now()]);

        $fresh = $tenant->fresh();
        Assert::assertInstanceOf(Tenant::class, $fresh);
        Assert::assertNotNull($fresh->last_activity_at);
        Assert::assertTrue($fresh->last_activity_at->isToday());
    });

    test('_can_manage_tenant_billing_cycles', function (): void {
$tenant = TenantFactory::new()->createOne();
        $subscription = TenantSubscriptionFactory::new()->createOne([
            'tenant_id' => $tenant->id,
            'billing_cycle' => 'monthly',
            'billing_amount' => 99.99,
            'next_billing_date' => now()->addMonth(),
        ]);

        $this->assertDatabaseHasRow('tenant_subscriptions', [
            'id' => $subscription->id,
            'billing_cycle' => 'monthly',
            'billing_amount' => 99.99,
        ]);

        Assert::assertSame('monthly', $subscription->billing_cycle);
        Assert::assertSame(99.99, $subscription->billing_amount);
        Assert::assertNotNull($subscription->next_billing_date);
        Assert::assertTrue($subscription->next_billing_date->isFuture());

        $subscription->update([
            'billing_cycle' => 'yearly',
            'billing_amount' => 999.99,
            'next_billing_date' => now()->addYear(),
        ]);

        $subFresh = $subscription->fresh();
        Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
        Assert::assertSame('yearly', $subFresh->billing_cycle);
        Assert::assertSame(999.99, $subFresh->billing_amount);
        Assert::assertNotNull($subFresh->next_billing_date);
        Assert::assertTrue($subFresh->next_billing_date->isFuture());
    });
});
