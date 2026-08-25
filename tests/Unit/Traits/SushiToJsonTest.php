<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class, DatabaseTransactions::class);

/**
 * @param  array<array-key, mixed>  $data
 */
function writeSushiJsonFile(string $path, array $data): void
{
    $directory = dirname($path);
    File::makeDirectory($directory, 0755, true, true);
    File::put($path, json_encode($data, JSON_PRETTY_PRINT));
}

beforeEach(function (): void {
    $this->model = new TestSushiModel;
    $this->testJsonPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');

    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});

afterEach(function (): void {
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }

    Mockery::close();
});

it('returns correct json file path', function (): void {
<<<<<<< HEAD
   $expectedPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
=======
    $expectedPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
>>>>>>> laraxot/dev
    $actualPath = $this->sushiModel()->getJsonFile();

    expect($actualPath)->toBe($expectedPath);
});

it('returns empty array when json file not exists', function (): void {
<<<<<<< HEAD
   $rows = $this->sushiModel()->getSushiRows();
=======
    $rows = $this->sushiModel()->getSushiRows();
>>>>>>> laraxot/dev

    expect($rows)->toBe([]);
});

it('throws exception when json data is invalid', function (): void {
<<<<<<< HEAD
   writeSushiJsonFile($this->sushiJsonPath(), []);
=======
    writeSushiJsonFile($this->sushiJsonPath(), []);
>>>>>>> laraxot/dev

    File::put($this->sushiJsonPath(), 'invalid json content');

    expect(fn () => $this->sushiModel()->getSushiRows())
        ->toThrow(Exception::class, 'Data is not array ['.$this->sushiJsonPath().']');
});

it('loads valid json data correctly', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key' => 'value1'],
        ],
        '2' => [
            'id' => 2,
            'name' => 'Test Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
            'metadata' => ['key' => 'value2'],
        ],
    ];

<<<<<<< HEAD
   writeSushiJsonFile($this->sushiJsonPath(), $testData);
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);
>>>>>>> laraxot/dev

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
});

it('normalizes nested arrays in json data', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item',
            'metadata' => ['nested' => ['deep' => 'value']],
            'tags' => ['tag1', 'tag2'],
        ],
    ];

<<<<<<< HEAD
   writeSushiJsonFile($this->sushiJsonPath(), $testData);
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);
>>>>>>> laraxot/dev

    $rows = $this->sushiModel()->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    expect($row['metadata'])->toBeString();
    expect($row['tags'])->toBeString();
    expect(json_decode(SafeStringCastAction::cast($row['metadata']), true))->toBe(['nested' => ['deep' => 'value']]);
    expect(json_decode(SafeStringCastAction::cast($row['tags']), true))->toBe(['tag1', 'tag2']);
});

it('saves data to json file successfully', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Test Item'],
        '2' => ['id' => 2, 'name' => 'Another Item'],
    ];

<<<<<<< HEAD
   $result = $this->sushiModel()->saveToJson($testData);
=======
    $result = $this->sushiModel()->saveToJson($testData);
>>>>>>> laraxot/dev

    expect($result)->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();

    $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

    expect($savedData)->toBe($testData);
});

it('creates directory if not exists when saving', function (): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Test']];

<<<<<<< HEAD
   $result = $this->sushiModel()->saveToJson($testData);
=======
    $result = $this->sushiModel()->saveToJson($testData);
>>>>>>> laraxot/dev

    expect($result)->toBeTrue();
    expect(File::exists(dirname($this->sushiJsonPath())))->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();
});

it('returns false when saving fails', function (): void {
    File::shouldReceive('put')->once()->andReturn(false);

    $result = $this->sushiModel()->saveToJson(['1' => ['id' => 1, 'name' => 'Test']]);

    expect($result)->toBeFalse();
});

it('loads existing data correctly', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

<<<<<<< HEAD
   writeSushiJsonFile($this->sushiJsonPath(), $testData);
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);
>>>>>>> laraxot/dev

    $existingData = $this->sushiModel()->loadExistingData();

    expect($existingData)->toBe($testData);
});

it('returns empty array when no existing data', function (): void {
<<<<<<< HEAD
   $existingData = $this->sushiModel()->loadExistingData();
=======
    $existingData = $this->sushiModel()->loadExistingData();
>>>>>>> laraxot/dev

    expect($existingData)->toBe([]);
});

it('works with sushi package integration', function (): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Sushi Item 1',
            'description' => 'Description 1',
            'status' => 'active',
        ],
        '2' => [
            'id' => 2,
            'name' => 'Sushi Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
        ],
    ];

<<<<<<< HEAD
   writeSushiJsonFile($this->sushiJsonPath(), $testData);
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);
>>>>>>> laraxot/dev

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);
    expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Sushi Item 1');
    expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Sushi Item 2');
});
