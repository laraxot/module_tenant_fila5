<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Traits\SushiToJson;
use Modules\Tenant\Models\Tenant;
use Tests\TestCase;

// Test model using SushiToJson
class SushiToJsonTestModel
{
    use SushiToJson;

    protected $table = 'sushi_json_test';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected function getJsonPath(): string
    {
        return base_path("tenants/{tenant}/data/sushi-test.json");
    }

    protected function getColumns(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'email' => 'string',
            'active' => 'boolean',
        ];
    }
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->tenant = Tenant::factory()->create(['name' => 'test-tenant']);
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    \Illuminate\Support\Facades\File::makeDirectory($dataDir, 0755, true);
    \Illuminate\Support\Facades\File::put(
        $dataDir . '/sushi-test.json',
        json_encode([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'active' => true],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'active' => false],
        ])
    );
});

afterEach(function () {
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    if (\Illuminate\Support\Facades\File::exists($dataDir)) {
        \Illuminate\Support\Facades\File::deleteDirectory($dataDir);
    }
});

describe('SushiToJson Trait', function () {
    it('loads data from JSON file', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toHaveCount(2);
        expect($rows[0]['id'])->toBe(1);
        expect($rows[0]['name'])->toBe('John Doe');
        expect($rows[1]['email'])->toBe('jane@example.com');
    });

    it('returns correct columns schema', function () {
        $model = new SushiToJsonTestModel();

        $columns = $model->getColumns();

        expect($columns)->toBeArray()
            ->toHaveKeys(['id', 'name', 'email', 'active']);
        expect($columns['id'])->toBe('integer');
        expect($columns['active'])->toBe('boolean');
    });

    it('queries data with where', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $activeUsers = $model->where('active', true)->get();

        expect($activeUsers)->toHaveCount(1);
        expect($activeUsers->first()->name)->toBe('John Doe');
    });

    it('queries data with orderBy', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $ordered = $model->orderBy('name', 'desc')->get();

        expect($ordered->first()->name)->toBe('John Doe');
    });

    it('queries data with limit', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $limited = $model->limit(1)->get();

        expect($limited)->toHaveCount(1);
    });

    it('finds by primary key', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $found = $model->find(1);

        expect($found)->not->toBeNull();
        expect($found->id)->toBe(1);
        expect($found->name)->toBe('John Doe');
    });

    it('returns null for non-existent ID', function () {
        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $found = $model->find(999);

        expect($found)->toBeNull();
    });

    it('handles missing JSON file', function () {
        $tenant2 = Tenant::factory()->create(['name' => 'no-json']);
        $model = new SushiToJsonTestModel();
        $model->setTenant($tenant2->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toBeEmpty();
    });

    it('handles malformed JSON', function () {
        $dataDir = base_path("tenants/{$this->tenant->name}/data");
        \Illuminate\Support\Facades\File::put($dataDir . '/sushi-test.json', 'invalid json');

        $model = new SushiToJsonTestModel();
        $model->setTenant($this->tenant->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toBeEmpty();
    });
});