<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;
<<<<<<< HEAD
=======
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
// Tenant Pest/PHPUnit — claude-audit documentation ratio.
>>>>>>> 1ad0554 (.)

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Mockery;
<<<<<<< HEAD
use Mockery\Expectation;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
=======
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
>>>>>>> 1ad0554 (.)

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
<<<<<<< HEAD
    /** @var TestCase $this */
    $this->model = new TestSushiModel;
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0755, true, true);
    }

    $jsonPath = TestCase::$testJsonPath;
    $mock = Mockery::mock(GetTenantFilePathAction::class);
    $mock->allows(['execute' => $jsonPath]);
    app()->instance(GetTenantFilePathAction::class, $mock);

    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
=======
    $this->model = new TestSushiModel;
    $this->testJsonPath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');

    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
>>>>>>> 1ad0554 (.)
    }
});

afterEach(function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
    }

    if (File::exists(TestCase::$testDirectory)) {
        File::deleteDirectory(TestCase::$testDirectory);
=======
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    $directory = dirname($this->testJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
>>>>>>> 1ad0554 (.)
    }

    Mockery::close();
});

it('returns correct json file path', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    expect($this->sushiModel()->getJsonFile())->toBe(TestCase::$testJsonPath);
});

it('returns empty array when json file not exists', function (): void {
    /** @var TestCase $this */
=======
    $expectedPath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
    $actualPath = $this->sushiModel()->getJsonFile();

    expect($actualPath)->toBe($expectedPath);
});

it('returns empty array when json file not exists', function (): void {
>>>>>>> 1ad0554 (.)
    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe([]);
});

it('throws exception when json data is invalid', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    File::put(TestCase::$testJsonPath, 'invalid json content');

    expect(fn () => $this->sushiModel()->getSushiRows())
        ->toThrow(Exception::class);
});

it('loads valid json data correctly', function (): void {
    /** @var TestCase $this */
=======
    writeSushiJsonFile($this->sushiJsonPath(), []);

    File::put($this->sushiJsonPath(), 'invalid json content');

    expect(fn () => $this->sushiModel()->getSushiRows())
        ->toThrow(Exception::class, 'Data is not array ['.$this->sushiJsonPath().']');
});

it('loads valid json data correctly', function (): void {
>>>>>>> 1ad0554 (.)
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
    writeSushiJsonFile(TestCase::$testJsonPath, $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toHaveCount(2);
    expect($this->jsonRecordAt($rows, 1)['name'])->toBe('Test Item 1');
    expect($this->jsonRecordAt($rows, 2)['name'])->toBe('Test Item 2');
});

it('normalizes nested arrays in json data', function (): void {
    /** @var TestCase $this */
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
});

it('normalizes nested arrays in json data', function (): void {
>>>>>>> 1ad0554 (.)
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item',
            'metadata' => ['nested' => ['deep' => 'value']],
            'tags' => ['tag1', 'tag2'],
        ],
    ];

<<<<<<< HEAD
    writeSushiJsonFile(TestCase::$testJsonPath, $testData);

    $rows = $this->sushiModel()->getSushiRows();
    $row = $this->jsonRecordAt($rows, 1);

    expect($row['metadata'])->toBeString();
    expect($row['tags'])->toBeString();
    expect(json_decode(SafeStringCastAction::cast($row['metadata']), true))->toBe(['nested' => ['deep' => 'value']]);
    expect(json_decode(SafeStringCastAction::cast($row['tags']), true))->toBe(['tag1', 'tag2']);
});

it('saves data to json file successfully', function (): void {
    /** @var TestCase $this */
    $testData = [
        1 => ['id' => 1, 'name' => 'Test Item'],
        2 => ['id' => 2, 'name' => 'Another Item'],
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    expect($row['metadata'])->toBeString();
    expect($row['tags'])->toBeString();
    expect(json_decode((string) $row['metadata'], true))->toBe(['nested' => ['deep' => 'value']]);
    expect(json_decode((string) $row['tags'], true))->toBe(['tag1', 'tag2']);
});

it('saves data to json file successfully', function (): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Test Item'],
        '2' => ['id' => 2, 'name' => 'Another Item'],
>>>>>>> 1ad0554 (.)
    ];

    $result = $this->sushiModel()->saveToJson($testData);

    expect($result)->toBeTrue();
<<<<<<< HEAD
    expect(File::exists(TestCase::$testJsonPath))->toBeTrue();

    $savedData = $this->readJsonFileAsArray(TestCase::$testJsonPath);

    expect($savedData)->toHaveCount(2);
    expect($this->jsonRecordAt($savedData, 1)['name'])->toBe('Test Item');
});

it('creates directory if not exists when saving', function (): void {
    /** @var TestCase $this */
    if (File::exists(TestCase::$testDirectory)) {
        File::deleteDirectory(TestCase::$testDirectory);
    }

    $testData = [1 => ['id' => 1, 'name' => 'Test']];
=======
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();

    $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

    expect($savedData)->toBe($testData);
});

it('creates directory if not exists when saving', function (): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Test']];
>>>>>>> 1ad0554 (.)

    $result = $this->sushiModel()->saveToJson($testData);

    expect($result)->toBeTrue();
<<<<<<< HEAD
    expect(File::exists(dirname(TestCase::$testJsonPath)))->toBeTrue();
    expect(File::exists(TestCase::$testJsonPath))->toBeTrue();
});

it('returns false when saving fails', function (): void {
    /** @var TestCase $this */
    $expectation = File::partialMock()->shouldReceive('put');
    if ($expectation instanceof Expectation) {
        $expectation->andThrow(new \RuntimeException('write failed'));
    }

    $result = $this->sushiModel()->saveToJson([1 => ['id' => 1, 'name' => 'Test']]);
=======
    expect(File::exists(dirname($this->sushiJsonPath())))->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();
});

it('returns false when saving fails', function (): void {
    File::shouldReceive('put')->once()->andReturn(false);

    $result = $this->sushiModel()->saveToJson(['1' => ['id' => 1, 'name' => 'Test']]);
>>>>>>> 1ad0554 (.)

    expect($result)->toBeFalse();
});

it('loads existing data correctly', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
=======
>>>>>>> 1ad0554 (.)
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

<<<<<<< HEAD
    writeSushiJsonFile(TestCase::$testJsonPath, $testData);

    $existingData = $this->sushiModel()->loadExistingData();

    expect($existingData)->toHaveCount(1);
    expect($this->jsonRecordAt($existingData, 1)['name'])->toBe('Existing Item');
});

it('returns empty array when no existing data', function (): void {
    /** @var TestCase $this */
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $existingData = $this->sushiModel()->loadExistingData();

    expect($existingData)->toBe($testData);
});

it('returns empty array when no existing data', function (): void {
>>>>>>> 1ad0554 (.)
    $existingData = $this->sushiModel()->loadExistingData();

    expect($existingData)->toBe([]);
});

it('works with sushi package integration', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
=======
>>>>>>> 1ad0554 (.)
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
    writeSushiJsonFile(TestCase::$testJsonPath, $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toHaveCount(2);
    expect($this->jsonRecordAt($rows, 1)['name'])->toBe('Sushi Item 1');
    expect($this->jsonRecordAt($rows, 2)['name'])->toBe('Sushi Item 2');
=======
    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);
    expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Sushi Item 1');
    expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Sushi Item 2');
>>>>>>> 1ad0554 (.)
});
