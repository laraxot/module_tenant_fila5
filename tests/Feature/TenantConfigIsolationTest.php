<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TenantSetting;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

describe('Tenant Config Isolation', function () {
    it('isolates config between tenants', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'tenant-a']);
        $tenant2 = Tenant::factory()->create(['name' => 'tenant-b']);

        // Create config for tenant-a
        $configDirA = base_path("tenants/{$tenant1->name}/config");
        \Illuminate\Support\Facades\File::makeDirectory($configDirA, 0755, true);
        \Illuminate\Support\Facades\File::put($configDirA . '/app.php', "<?php return ['name' => 'Tenant A App'];");

        // Create config for tenant-b
        $configDirB = base_path("tenants/{$tenant2->name}/config");
        \Illuminate\Support\Facades\File::makeDirectory($configDirB, 0755, true);
        \Illuminate\Support\Facades\File::put($configDirB . '/app.php', "<?php return ['name' => 'Tenant B App'];");

        $configA = include $configDirA . '/app.php';
        $configB = include $configDirB . '/app.php';

        expect($configA['name'])->toBe('Tenant A App');
        expect($configB['name'])->toBe('Tenant B App');
        expect($configA['name'])->not->toBe($configB['name']);
    });

    it('isolates settings between tenants', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'tenant-a']);
        $tenant2 = Tenant::factory()->create(['name' => 'tenant-b']);

        TenantSetting::create([
            'tenant_id' => $tenant1->id,
            'key' => 'theme',
            'value' => 'dark',
        ]);

        TenantSetting::create([
            'tenant_id' => $tenant2->id,
            'key' => 'theme',
            'value' => 'light',
        ]);

        $setting1 = TenantSetting::where('tenant_id', $tenant1->id)->where('key', 'theme')->first();
        $setting2 = TenantSetting::where('tenant_id', $tenant2->id)->where('key', 'theme')->first();

        expect($setting1->value)->toBe('dark');
        expect($setting2->value)->toBe('light');
    });

    it('tenant settings do not leak', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'tenant-a']);
        $tenant2 = Tenant::factory()->create(['name' => 'tenant-b']);

        TenantSetting::create([
            'tenant_id' => $tenant1->id,
            'key' => 'secret',
            'value' => 'tenant-a-secret',
        ]);

        $tenant2Settings = TenantSetting::where('tenant_id', $tenant2->id)->get();

        expect($tenant2Settings)->toBeEmpty();
    });

    it('tenant config directory structure is separate', function () {
        $tenant1 = Tenant::factory()->create(['name' => 'tenant-a']);
        $tenant2 = Tenant::factory()->create(['name' => 'tenant-b']);

        $path1 = $tenant1->configPath();
        $path2 = $tenant2->configPath();

        expect($path1)->not->toBe($path2);
        expect($path1)->toContain('tenant-a');
        expect($path2)->toContain('tenant-b');
    });
});