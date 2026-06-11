<?php

declare(strict_types=1);

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

uses(TestCase::class);

test('can create and manage tenants', function (): void {
    /** @var TestCase $this */

    // Arrange
    $user = UserFactory::new()->createOne();
    Assert::assertInstanceOf(User::class, $user);

    // Act
    $tenant = TenantFactory::new()->createOne([
        'name' => 'Test Studio',
        'slug' => 'test-studio',
        'is_active' => true,
    ]);
    Assert::assertInstanceOf(Tenant::class, $tenant);

    // Assert
    $this->assertDatabaseHasRow('tenants', [
        'id' => $tenant->id,
        'name' => 'Test Studio',
        'slug' => 'test-studio',
    ]);

    Assert::assertSame('Test Studio', $tenant->name);
    Assert::assertSame('test-studio', $tenant->slug);
    Assert::assertTrue($tenant->is_active);
});

test('can manage tenant domains', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();
    Assert::assertInstanceOf(Tenant::class, $tenant);

    // Act
    $domain = TenantDomainFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'domain' => 'test.example.com',
        'is_primary' => true,
        'status' => 'active',
    ]);
    Assert::assertInstanceOf(TenantDomain::class, $domain);

    // Assert
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

test('can manage tenant settings', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();

    // Act
    $setting = TenantSettingFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'key' => 'app.name',
        'value' => 'Test Studio Application',
        'type' => 'string',
    ]);

    // Assert
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

test('can manage tenant subscriptions', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();

    // Act
    $subscription = TenantSubscriptionFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'plan_name' => 'Professional',
        'status' => 'active',
        'starts_at' => now(),
        'expires_at' => now()->addYear(),
        'max_users' => 50,
        'max_storage_gb' => 100,
    ]);

    // Assert
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

test('can validate tenant slug uniqueness', function (): void {
    /** @var TestCase $this */

    // Arrange & Act
    $tenant1 = TenantFactory::new()->createOne([
        'name' => 'Studio A',
        'slug' => 'studio-a',
    ]);
    $tenant2 = TenantFactory::new()->createOne([
        'name' => 'Studio B',
        'slug' => 'studio-b',
    ]);

    // Assert
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

test('can manage tenant status workflow', function (): void {
    /** @var TestCase $this */

    // Arrange - tenant inattivo
    $tenant = TenantFactory::new()->createOne([
        'is_active' => false,
    ]);

    // Act - Attivazione
    $tenant->update(['is_active' => true]);

    // Assert
    $tenantFresh = $tenant->fresh();
    Assert::assertInstanceOf(Tenant::class, $tenantFresh);
    Assert::assertTrue($tenantFresh->is_active);
    // Act - Disattivazione
    $tenant->update(['is_active' => false]);

    // Assert
    $tenantFresh = $tenant->fresh();
    Assert::assertInstanceOf(Tenant::class, $tenantFresh);
    Assert::assertFalse($tenantFresh->is_active);
    // Act - Riattivazione
    $tenant->update(['is_active' => true]);

    // Assert
    $tenantFresh = $tenant->fresh();
    Assert::assertInstanceOf(Tenant::class, $tenantFresh);
    Assert::assertTrue($tenantFresh->is_active);
});

test('can handle tenant domain verification', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();

    // Act
    $domain = TenantDomainFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'domain' => 'unverified.example.com',
        'is_primary' => false,
        'status' => 'pending_verification',
        'verification_token' => 'abc123',
    ]);

    // Assert
    $this->assertDatabaseHasRow('tenant_domains', [
        'id' => $domain->id,
        'status' => 'pending_verification',
    ]);

    Assert::assertSame('pending_verification', $domain->status);
    Assert::assertSame('abc123', $domain->verification_token);
    // Act - Verify domain
    $domain->update([
        'status' => 'active',
        'verified_at' => now(),
        'verification_token' => null,
    ]);

    // Assert
    $domainFresh = $domain->fresh();
    Assert::assertInstanceOf(TenantDomain::class, $domainFresh);
    Assert::assertSame('active', $domainFresh->status);
    Assert::assertNotNull($domainFresh->verified_at);
    Assert::assertNull($domainFresh->verification_token);
});

test('can manage tenant storage limits', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();
    $subscription = TenantSubscriptionFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'max_storage_gb' => 100,
        'current_storage_gb' => 25,
    ]);

    // Assert
    $this->assertDatabaseHasRow('tenant_subscriptions', [
        'id' => $subscription->id,
        'max_storage_gb' => 100,
        'current_storage_gb' => 25,
    ]);

    Assert::assertSame(100, $subscription->max_storage_gb);
    Assert::assertSame(25, $subscription->current_storage_gb);
    Assert::assertSame(75, $subscription->max_storage_gb - $subscription->current_storage_gb);
    // Act - Update storage usage
    $subscription->update(['current_storage_gb' => 50]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
    Assert::assertSame(50, $subFresh->current_storage_gb);
    Assert::assertSame(50, $subFresh->max_storage_gb - $subFresh->current_storage_gb);
});

test('can manage tenant user limits', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();
    $subscription = TenantSubscriptionFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'max_users' => 50,
        'current_users' => 10,
    ]);

    // Assert
    $this->assertDatabaseHasRow('tenant_subscriptions', [
        'id' => $subscription->id,
        'max_users' => 50,
        'current_users' => 10,
    ]);

    Assert::assertSame(50, $subscription->max_users);
    Assert::assertSame(10, $subscription->current_users);
    Assert::assertSame(40, $subscription->max_users - $subscription->current_users);
    // Act - Add more users
    $subscription->update(['current_users' => 25]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
    Assert::assertSame(25, $subFresh->current_users);
    Assert::assertSame(25, $subFresh->max_users - $subFresh->current_users);
});

test('can handle tenant subscription expiration', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();
    $subscription = TenantSubscriptionFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'status' => 'active',
        'expires_at' => now()->subDays(1), // Expired yesterday
    ]);

    // Assert
    $this->assertDatabaseHasRow('tenant_subscriptions', [
        'id' => $subscription->id,
        'status' => 'active',
    ]);

    Assert::assertNotNull($subscription->expires_at);
    Assert::assertTrue($subscription->expires_at->isPast());
    // Act - Mark as expired
    $subscription->update(['status' => 'expired']);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
    Assert::assertSame('expired', $subFresh->status);
});

test('can manage tenant settings hierarchy', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();

    // Act - Create multiple settings
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

    // Assert
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

test('can validate tenant domain formats', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();

    // Act & Assert - Valid domains
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

test('can track tenant activity', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne([
        'created_at' => now()->subMonths(3),
        'last_activity_at' => now()->subDays(5),
    ]);

    // Act - Update last activity
    $tenant->update(['last_activity_at' => now()]);

    // Assert
    $fresh = $tenant->fresh();
    Assert::assertInstanceOf(Tenant::class, $fresh);
    Assert::assertNotNull($fresh->last_activity_at);
    Assert::assertTrue($fresh->last_activity_at->isToday());
});

test('can manage tenant billing cycles', function (): void {
    /** @var TestCase $this */

    // Arrange
    $tenant = TenantFactory::new()->createOne();
    $subscription = TenantSubscriptionFactory::new()->createOne([
        'tenant_id' => $tenant->id,
        'billing_cycle' => 'monthly',
        'billing_amount' => 99.99,
        'next_billing_date' => now()->addMonth(),
    ]);

    // Assert
    $this->assertDatabaseHasRow('tenant_subscriptions', [
        'id' => $subscription->id,
        'billing_cycle' => 'monthly',
        'billing_amount' => 99.99,
    ]);

    Assert::assertSame('monthly', $subscription->billing_cycle);
    Assert::assertSame(99.99, $subscription->billing_amount);
    Assert::assertNotNull($subscription->next_billing_date);
    Assert::assertTrue($subscription->next_billing_date->isFuture());
    // Act - Update billing cycle
    $subscription->update([
        'billing_cycle' => 'yearly',
        'billing_amount' => 999.99,
        'next_billing_date' => now()->addYear(),
    ]);

    // Assert
    $subFresh = $subscription->fresh();
    Assert::assertInstanceOf(TenantSubscription::class, $subFresh);
    Assert::assertSame('yearly', $subFresh->billing_cycle);
    Assert::assertSame(999.99, $subFresh->billing_amount);
    Assert::assertNotNull($subFresh->next_billing_date);
    Assert::assertTrue($subFresh->next_billing_date->isFuture());
});
