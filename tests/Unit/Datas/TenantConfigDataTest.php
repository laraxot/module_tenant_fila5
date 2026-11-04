<?php

declare(strict_types=1);

use Modules\Tenant\Datas\TenantConfigData;
use Modules\Tenant\Filament\Pages\SettingPage;
use Modules\Tenant\Tests\TestCase;

uses(TestCase::class)->group('no-tenant-db');

test('setting page resolves config name and data class by convention', function (): void {
    expect(SettingPage::getConfigName())->toBe('tenant')
        ->and(SettingPage::getConfigDataClass())->toBe(TenantConfigData::class);
});

test('config data reads the tenant file named after the module', function (): void {
    expect(TenantConfigData::tenantConfigName())->toBe('tenant');
});
