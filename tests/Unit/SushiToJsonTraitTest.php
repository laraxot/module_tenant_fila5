<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Mockery\Expectation;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
<<<<<<< HEAD
    $this->model = new TestSushiModel;
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
    }

    $jsonPath = $this->testJsonPath;
=======
    $this->model = new TestSushiModel();
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0o755, true, true);
    }

    $jsonPath = TestCase::$testJsonPath;
>>>>>>> laraxot/dev
    $mock = Mockery::mock(GetTenantFilePathAction::class);
    $mock->allows(['execute' => $jsonPath]);
    app()->instance(GetTenantFilePathAction::class, $mock);

<<<<<<< HEAD
    $this->createTestData = static fn (): array => [
=======
    TestCase::$createTestData = static fn (): array => [
>>>>>>> laraxot/dev
        1 => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key1' => 'value1'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
        2 => [
            'id' => 2,
            'name' => 'Test Item 2',
            'description' => 'Description 2',
            'status' => 'inactive',
            'metadata' => ['key3' => 'value3'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
    ];
});

afterEach(function (): void {
    /** @var TestCase $this */
<<<<<<< HEAD
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
=======
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
    }

    if (File::exists(TestCase::$testDirectory)) {
        File::deleteDirectory(TestCase::$testDirectory);
>>>>>>> laraxot/dev
    }

    Mockery::close();
});

describe('SushiToJson Trait', function (): void {
    it('returns correct json file path', function (): void {
        /** @var TestCase $this */
<<<<<<< HEAD
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
=======
        expect($this->sushiModel()->getJsonFile())->toBe(TestCase::$testJsonPath);
>>>>>>> laraxot/dev
    });

    it('loads existing data from json file', function (): void {
        /** @var TestCase $this */
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();
<<<<<<< HEAD
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
=======
        File::put(TestCase::$testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
>>>>>>> laraxot/dev

        $rows = $this->sushiModel()->loadExistingData();

        expect($rows)->toHaveCount(2);
        expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Test Item 1');
        expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function (): void {
        /** @var TestCase $this */
        expect($this->sushiModel()->getSushiRows())->toBeEmpty();
    });

    it('throws exception with malformed json', function (): void {
        /** @var TestCase $this */
<<<<<<< HEAD
        File::put($this->testJsonPath, 'invalid json content');
=======
        File::put(TestCase::$testJsonPath, 'invalid json content');
>>>>>>> laraxot/dev

        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Syntax error');
    });

    it('throws exception with non array data', function (): void {
        /** @var TestCase $this */
<<<<<<< HEAD
        File::put($this->testJsonPath, '"string data"');
=======
        File::put(TestCase::$testJsonPath, '"string data"');
>>>>>>> laraxot/dev

        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Data is not array');
    });

    it('normalizes nested arrays to json strings', function (): void {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

<<<<<<< HEAD
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
=======
        File::put(TestCase::$testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));
>>>>>>> laraxot/dev

        $rows = $this->sushiModel()->getSushiRows();
        $row = $this->jsonRecordAt($rows, '1');

        expect($row['metadata'])->toBeString()->toBe('{"nested":"value"}');
        expect($row['tags'])->toBeString()->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function (): void {
        /** @var TestCase $this */
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
<<<<<<< HEAD
        expect($this->testJsonPath)->toBeFile();

        $savedData = $this->readJsonFileAsArray($this->testJsonPath);
=======
        expect(TestCase::$testJsonPath)->toBeFile();

        $savedData = $this->readJsonFileAsArray(TestCase::$testJsonPath);
>>>>>>> laraxot/dev
        expect($savedData)->toHaveCount(2);
        expect($this->jsonRecordAt($savedData, 1)['name'])->toBe('Test Item 1');
    });

    it('creates directory if not exists', function (): void {
        /** @var TestCase $this */
<<<<<<< HEAD
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
=======
        if (File::exists(TestCase::$testDirectory)) {
            File::deleteDirectory(TestCase::$testDirectory);
>>>>>>> laraxot/dev
        }

        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
<<<<<<< HEAD
        expect($this->testDirectory)->toBeDirectory();
        expect($this->testJsonPath)->toBeFile();
=======
        expect(TestCase::$testDirectory)->toBeDirectory();
        expect(TestCase::$testJsonPath)->toBeFile();
>>>>>>> laraxot/dev
    });

    it('handles save errors gracefully', function (): void {
        /** @var TestCase $this */
        $expectation = File::partialMock()->shouldReceive('put');
        if ($expectation instanceof Expectation) {
            $expectation->andThrow(new \RuntimeException('write failed'));
        }

        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeFalse();
    });

    it('handles creating event correctly', function (): void {
        /** @var TestCase $this */
        Auth::shouldReceive('id')->andReturn(1);

<<<<<<< HEAD
        $model = new TestSushiModel;
=======
        $model = new TestSushiModel();
>>>>>>> laraxot/dev
        $model->fill(['name' => 'New Item', 'description' => 'New Description']);

        expect($model->name)->toBe('New Item');
        expect($model->getJsonFile())->toEndWith('test_sushi.json');
    });

    it('integrates with tenant service correctly', function (): void {
        /** @var TestCase $this */
<<<<<<< HEAD
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
=======
        expect($this->sushiModel()->getJsonFile())->toBe(TestCase::$testJsonPath);
>>>>>>> laraxot/dev
    });

    it('handles large datasets efficiently', function (): void {
        /** @var TestCase $this */
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData[$i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'description' => "Description for item {$i}",
                'status' => ($i % 2) === 0 ? 'active' : 'inactive',
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        $startTime = microtime(true);
        expect($this->sushiModel()->saveToJson($largeData))->toBeTrue();
        expect(microtime(true) - $startTime)->toBeLessThan(50.0);

        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
        expect(microtime(true) - $startTime)->toBeLessThan(25.0);
        expect($rows)->toHaveCount(1000);
    });

    it('maintains data integrity during operations', function (): void {
        /** @var TestCase $this */
        /** @var array<int, array<string, mixed>> $originalData */
        $originalData = $this->sushiTestData();
<<<<<<< HEAD
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));
=======
        File::put(TestCase::$testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));
>>>>>>> laraxot/dev

        expect($this->sushiModel()->loadExistingData())->toHaveCount(2);
        expect($this->jsonRecordAt($this->sushiModel()->loadExistingData(), 1)['name'])->toBe('Test Item 1');

        $updatedData = $originalData;
        $updatedData[1]['name'] = 'Updated Name';

        expect($this->sushiModel()->saveToJson($updatedData))->toBeTrue();

        $finalData = $this->sushiModel()->loadExistingData();
        expect($this->jsonRecordAt($finalData, 1)['name'])->toBe('Updated Name');
        expect($this->jsonRecordAt($finalData, 2)['name'])->toBe('Test Item 2');
    });
});
