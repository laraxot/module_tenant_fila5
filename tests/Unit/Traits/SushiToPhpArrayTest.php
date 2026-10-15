<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Modules\Tenant\Models\Traits\SushiToPhpArray;
use Modules\Tenant\Models\Tenant;
use Tests\TestCase;

class SushiToPhpArrayTestModel
{
    use SushiToPhpArray;

    protected $table = 'sushi_php_array_test';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected function getPhpArrayPath(): string
    {
        return base_path("tenants/{tenant}/data/sushi-php-array.php");
    }

    protected function getColumns(): array
    {
        return [
            'id' => 'integer',
            'title' => 'string',
            'price' => 'float',
        ];
    }
}

uses(TestCase::class, RefreshDatabase::class, WithFaker::class);

beforeEach(function () {
    $this->tenant = Tenant::factory()->create(['name' => 'test-tenant']);
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    \Illuminate\Support\Facades\File::makeDirectory($dataDir, 0755, true);
    \Illuminate\Support\Facades\File::put(
        $dataDir . '/sushi-php-array.php',
        '<?php return [' . PHP_EOL .
        "    ['id' => 1, 'title' => 'Product A', 'price' => 99.99]," . PHP_EOL .
        "    ['id' => 2, 'title' => 'Product B', 'price' => 149.50]," . PHP_EOL .
        '];'
    );
});

afterEach(function () {
    $dataDir = base_path("tenants/{$this->tenant->name}/data");
    if (\Illuminate\Support\Facades\File::exists($dataDir)) {
        \Illuminate\Support\Facades\File::deleteDirectory($dataDir);
    }
});

describe('SushiToPhpArray Trait', function () {
    it('loads data from PHP array file', function () {
        $model = new SushiToPhpArrayTestModel();
        $model->setTenant($this->tenant->name);

        $rows = $model->getRows();

        expect($rows)->toBeArray()->toHaveCount(2);
        expect($rows[0]['title'])->toBe('Product A');
        expect($rows[0]['price'])->toBe(99.99);
    });

    it('returns correct columns', function () {
        $model = new SushiToPhpArrayTestModel();
        $columns = $model->getColumns();

        expect($columns)->toHaveKeys(['id', 'title', 'price']);
    });

    it('queries with where', function () {
        $model = new SushiToPhpArrayTestModel();
        $model->setTenant($this->tenant->name);

        $expensive = $model->where('price', '>', 100)->get();

        expect($expensive)->toHaveCount(1);
        expect($expensive->first()->title)->toBe('Product B');
    });

    it('finds by ID', function () {
        $model = new SushiToPhpArrayTestModel();
        $model->setTenant($this->tenant->name);

        $found = $model->find(2);

        expect($found->title)->toBe('Product B');
    });
});