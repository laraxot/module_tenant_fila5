<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Tenant\Models\Tenant;
use Tests\TestCase;

class SushiToJsonsTestModel
{
    use SushiToJsons;

    protected $table = 'sushi_jsons_test';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected function getJsonPaths(): array
    {
        return [
            base_path("tenants/{tenant}/data/sushi-1.json"),
            base_path("tenants/{tenant}/data/sushi-2.json"),
        ];
    }

    protected function getColumns(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'source' => 'string',
        ];
    }
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->tenant = Tenant::factory()->create(['name' => 'test-tenant']);
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    \Illuminate\Support\Facades\File::makeDirectory($dataDir, 0755, true);
    \Illuminate\Support\Facades\File::put(
        $dataDir . '/sushi-1.json',
        json_encode([
            ['id' => 1, 'name' => 'From JSON 1', 'source' => 'file-1'],
            ['id' => 2, 'name' => 'From JSON 1b', 'source' => 'file-1'],
        ])
    );
    \Illuminate\Support\Facades\File::put(
        $dataDir . '/sushi-2.json',
        json_encode([
            ['id' => 3, 'name' => 'From JSON 2', 'source' => 'file-2'],
        ])
    );
});

afterEach(function () {
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    if (\Illuminate\Support\Facades\File::exists($dataDir)) {
        \Illuminate\Support\Facades\File::deleteDirectory($dataDir);
    }
});

describe('SushiToJsons Trait', function () {
    it('loads and merges data from multiple JSON files', function () {
        $model = new SushiToJsonsTestModel();
        $model->setTenant($this->tenant->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toHaveCount(3);
        expect($rows[0]['source'])->toBe('file-1');
        expect($rows[2]['source'])->toBe('file-2');
    });

    it('returns correct columns', function () {
        $model = new SushiToJsonsTestModel();
        $columns = $model->getColumns();

        expect($columns)->toHaveKeys(['id', 'name', 'source']);
    });

    it('queries merged data', function () {
        $model = new SushiToJsonsTestModel();
        $model->setTenant($this->tenant->name);

        $fromFile1 = $model->where('source', 'file-1')->get();

        expect($fromFile1)->toHaveCount(2);
    });

    it('finds by ID across files', function () {
        $model = new SushiToJsonsTestModel();
        $model->setTenant($this->tenant->name);

        $found = $model->find(3);

        expect($found->source)->toBe('file-2');
    });

    it('handles missing files gracefully', function () {
        $tenant2 = Tenant::factory()->create(['name' => 'partial-json']);
        $dataDir = base_path("tenants/{$tenant2->name}/data");
        \Illuminate\Support\Facades\File::makeDirectory($dataDir, 0755, true);
        \Illuminate\Support\Facades\File::put($dataDir . '/sushi-1.json', json_encode([['id' => 1, 'name' => 'Only One', 'source' => 'file-1']]));
        // sushi-2.json missing

        $model = new SushiToJsonsTestModel();
        $model->setTenant($tenant2->name);

        $rows = $model->getRows();

        expect($rows)->toHaveCount(1);
    });
});