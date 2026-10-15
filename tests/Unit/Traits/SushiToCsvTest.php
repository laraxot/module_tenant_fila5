<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Traits\SushiToCsv;
use Modules\Tenant\Models\Tenant;
use Tests\TestCase;

class SushiToCsvTestModel
{
    use SushiToCsv;

    protected $table = 'sushi_csv_test';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected function getCsvPath(): string
    {
        return base_path("tenants/{tenant}/data/sushi-test.csv");
    }

    protected function getColumns(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'category' => 'string',
        ];
    }
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->tenant = Tenant::factory()->create(['name' => 'test-tenant']);
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    \Illuminate\Support\Facades\File::makeDirectory($dataDir, 0755, true);
    \Illuminate\Support\Facades\File::put(
        $dataDir . '/sushi-test.csv',
        "id,name,category\n" .
        "1,Item A,Electronics\n" .
        "2,Item B,Clothing\n" .
        "3,Item C,Electronics\n"
    );
});

afterEach(function () {
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    if (\Illuminate\Support\Facades\File::exists($dataDir)) {
        \Illuminate\Support\Facades\File::deleteDirectory($dataDir);
    }
});

describe('SushiToCsv Trait', function () {
    it('loads data from CSV file', function () {
        $model = new SushiToCsvTestModel();
        $model->setTenant($this->tenant->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toHaveCount(3);
        expect($rows[0]['name'])->toBe('Item A');
        expect($rows[0]['category'])->toBe('Electronics');
    });

    it('parses CSV headers correctly', function () {
        $model = new SushiToCsvTestModel();
        $columns = $model->getColumns();

        expect($columns)->toHaveKeys(['id', 'name', 'category']);
    });

    it('queries with where on CSV data', function () {
        $model = new SushiToCsvTestModel();
        $model->setTenant($this->tenant->name);

        $electronics = $model->where('category', 'Electronics')->get();

        expect($electronics)->toHaveCount(2);
        expect($electronics->pluck('name'))->toContain('Item A', 'Item C');
    });

    it('finds by ID', function () {
        $model = new SushiToCsvTestModel();
        $model->setTenant($this->tenant->name);

        $found = $model->find(2);

        expect($found->name)->toBe('Item B');
    });

    it('handles missing CSV file', function () {
        $tenant2 = Tenant::factory()->create(['name' => 'no-csv']);
        $model = new SushiToCsvTestModel();
        $model->setTenant($tenant2->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toBeEmpty();
    });
});