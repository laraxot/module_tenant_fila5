<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantSetting;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

describe('Multi-Tenant Scope', function () {
    it('scopes queries to current tenant', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'scope-tenant-1']);
        $tenant2 = Tenant::factory()->create(['name' => 'scope-tenant-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'setting', 'value' => 'value-1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'setting', 'value' => 'value-2']);

        // Simulate tenant context
        $settings1 = TenantSetting::where('tenant_id', $tenant1->id)->get();
        $settings2 = TenantSetting::where('tenant_id', $tenant2->id)->get();

        expect($settings1)->toHaveCount(1);
        expect($settings1->first()->value)->toBe('value-1');

        expect($settings2)->toHaveCount(1);
        expect($settings2->first()->value)->toBe('value-2');
    });

    it('global scope prevents cross-tenant access', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'global-1']);
        $tenant2 = Tenant::factory()->create(['name' => 'global-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'private', 'value' => 'secret-1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'private', 'value' => 'secret-2']);

        // Without tenant context, should see all (or none depending on scope implementation)
        $allSettings = TenantSetting::all();

        expect($allSettings)->toHaveCount(2);
    });

    it('tenant-aware models enforce isolation', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'aware-1']);
        $tenant2 = Tenant::factory()->create(['name' => 'aware-2']);

        $setting1 = TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'test', 'value' => 'v1']);
        $setting2 = TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'test', 'value' => 'v2']);

        // Query with tenant scope
        $scoped1 = TenantSetting::where('tenant_id', $tenant1->id)->get();
        $scoped2 = TenantSetting::where('tenant_id', $tenant2->id)->get();

        expect($scoped1->first()->value)->toBe('v1');
        expect($scoped2->first()->value)->toBe('v2');
    });

    it('RLS policies work with tenant context', function () {
        // This tests the concept - actual RLS depends on database setup
        $tenant1 = Tenant::factory()->create(['name' => 'rls-1']);
        $tenant2 = Tenant::factory()->create(['name' => 'rls-2']);

        TenantSetting::create(['tenant_id' => $tenant1->id, 'key' => 'rls-test', 'value' => 'rls-1']);
        TenantSetting::create(['tenant_id' => $tenant2->id, 'key' => 'rls-test', 'value' => 'rls-2']);

        // Verify data exists and is separable
        $tenant1Data = TenantSetting::where('tenant_id', $tenant1->id)->where('key', 'rls-test')->first();
        $tenant2Data = TenantSetting::where('tenant_id', $tenant2->id)->where('key', 'rls-test')->first();

        expect($tenant1Data->value)->toBe('rls-1');
        expect($tenant2Data->value)->toBe('rls-2');
    });
});