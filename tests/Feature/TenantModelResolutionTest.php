<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

describe('Tenant Model Resolution', function () {
    it('resolves tenant-specific config', function () {
        $tenant = Tenant::factory()->create(['name' => 'model-tenant']);
        $configDir = base_path("tenants/{$tenant->name}/config");
        \Illuminate\Support\Facades\File::makeDirectory($configDir, 0755, true);
        \Illuminate\Support\Facades\File::put($configDir . '/models.php', "<?php return ['user' => 'App\\Models\\CustomUser'];");

        $action = app(GetTenantConfigArrayAction::class);
        $config = $action->execute('models', $tenant->name);

        expect($config)->toHaveKey('user');
        expect($config['user'])->toBe('App\\Models\\CustomUser');
    });

    it('falls back to global config for models', function () {
        $tenant = Tenant::factory()->create(['name' => 'fallback-tenant']);
        config(['tenant.models.default' => 'App\\Models\\DefaultUser']);

        $action = app(GetTenantConfigArrayAction::class);
        $config = $action->execute('models', $tenant->name);

        expect($config['default'] ?? null)->toBe('App\\Models\\DefaultUser');
    });

    it('tenant-specific model overrides global', function () {
        $tenant = Tenant::factory()->create(['name' => 'override-tenant']);
        config(['tenant.models.user' => 'App\\Models\\GlobalUser']);

        $configDir = base_path("tenants/{$tenant->name}/config");
        \Illuminate\Support\Facades\File::makeDirectory($configDir, 0755, true);
        \Illuminate\Support\Facades\File::put($configDir . '/models.php', "<?php return ['user' => 'App\\Models\\TenantUser'];");

        $action = app(GetTenantConfigArrayAction::class);
        $config = $action->execute('models', $tenant->name);

        expect($config['user'])->toBe('App\\Models\\TenantUser');
    });

    it('resolves tenant model class from config', function () {
        $tenant = Tenant::factory()->create(['name' => 'resolve-tenant']);
        $configDir = base_path("tenants/{$tenant->name}/config");
        \Illuminate\Support\Facades\File::makeDirectory($configDir, 0755, true);
        \Illuminate\Support\Facades\File::put($configDir . '/models.php', "<?php return ['product' => 'Modules\\Shop\\Models\\Product'];");

        $action = app(GetTenantConfigArrayAction::class);
        $config = $action->execute('models', $tenant->name);

        $modelClass = $config['product'] ?? null;
        expect($modelClass)->toBe('Modules\\Shop\\Models\\Product');
        expect(class_exists($modelClass))->toBeFalse(); // Class may not exist, but resolution works
    });
});