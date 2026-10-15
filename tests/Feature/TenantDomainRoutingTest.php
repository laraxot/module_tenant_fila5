<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Domain;
use Modules\Tenant\Models\Tenant;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

describe('Tenant Domain Routing', function () {
    it('identifies tenant by primary domain', function () {
        $tenant = Tenant::factory()->create(['name' => 'primary-tenant']);
        Domain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'tenant.example.com',
            'is_primary' => true,
        ]);

        $found = Domain::where('domain', 'tenant.example.com')->first();

        expect($found)->not->toBeNull();
        expect($found->tenant_id)->toBe($tenant->id);
        expect($found->is_primary)->toBeTrue();
    });

    it('identifies tenant by alias domain', function () {
        $tenant = Tenant::factory()->create(['name' => 'alias-tenant']);
        Domain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'main.example.com',
            'is_primary' => true,
        ]);
        Domain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'alias.example.com',
            'is_primary' => false,
        ]);

        $alias = Domain::where('domain', 'alias.example.com')->first();

        expect($alias)->not->toBeNull();
        expect($alias->tenant_id)->toBe($tenant->id);
        expect($alias->is_primary)->toBeFalse();
    });

    it('returns null for unknown domain', function () {
        $found = Domain::where('domain', 'unknown.example.com')->first();

        expect($found)->toBeNull();
    });

    it('handles SSL status', function () {
        $tenant = Tenant::factory()->create();
        Domain::factory()->create([
            'tenant_id' => $tenant->id,
            'domain' => 'secure.example.com',
            'ssl_status' => 'active',
        ]);

        $domain = Domain::where('domain', 'secure.example.com')->first();

        expect($domain->ssl_status)->toBe('active');
    });

    it('tenant can have multiple domains', function () {
        $tenant = Tenant::factory()->create();

        Domain::factory()->create(['tenant_id' => $tenant->id, 'domain' => 'a.com', 'is_primary' => true]);
        Domain::factory()->create(['tenant_id' => $tenant->id, 'domain' => 'b.com', 'is_primary' => false]);
        Domain::factory()->create(['tenant_id' => $tenant->id, 'domain' => 'c.com', 'is_primary' => false]);

        $domains = Domain::where('tenant_id', $tenant->id)->get();

        expect($domains)->toHaveCount(3);
        expect($domains->where('is_primary', true))->toHaveCount(1);
    });
});