<?php

declare(strict_types=1);

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

/**
 * @property TestSushiModel $model
 * @property string $testDirectory
 * @property string $testJsonPath
 */
describe('SushiToJson Trait', function () {
    beforeEach(function () {
        /** @var TestCase $this */

        // Configura il modello di test
        $this->model = new TestSushiModel;

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json');
        $this->testJsonPath = $this->sushiTestDirectory().'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->sushiTestDirectory())) {
            File::makeDirectory($this->sushiTestDirectory(), 0o755, true, true);
        }

        // Mock TenantService per i test
        $jsonPath = $this->sushiJsonPath();
        $this->mockService(TenantService::class, function ($mock) use ($jsonPath): void {
            $mock->allows([
                'filePath' => static fn (string $path): string => $path === 'database/content/test_sushi.json'
                    ? $jsonPath
                    : $jsonPath,
            ]);
        });
    });

    afterEach(function () {
        /** @var TestCase $this */

        // Cleanup file di test
        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        if (File::exists($this->sushiTestDirectory())) {
            File::deleteDirectory($this->sushiTestDirectory());
        }
    });

    test('returns correct json file path', function () {
        /** @var TestCase $this */
        $path = $this->sushiModel()->getJsonFile();

        Assert::assertSame($this->sushiJsonPath(), $path);
        Assert::assertStringEndsWith('test_sushi.json', $path);
    });

    test('loads existing data from json file', function () {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test Item 1',
                'description' => 'Description 1',
                'status' => 'active',
                'metadata' => ['key1' => 'value1', 'key2' => 'value2'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
            '2' => [
                'id' => 2,
                'name' => 'Test Item 2',
                'description' => 'Description 2',
                'status' => 'inactive',
                'metadata' => ['key3' => 'value3'],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
        ];

        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->loadExistingData();

        Assert::assertIsArray($rows);
        Assert::assertCount(2, $rows);
        Assert::assertSame('Test Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Test Item 2', \sushiRowById($rows, 2)['name']);
    });

    test('returns empty array when file not exists', function () {
        /** @var TestCase $this */
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsArray($rows);
        Assert::assertEmpty($rows);
    });

    test('throws exception with malformed json', function () {
        /** @var TestCase $this */
        File::put($this->sushiJsonPath(), 'invalid json content');

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    });

    test('throws exception with non array data', function () {
        /** @var TestCase $this */
        File::put($this->sushiJsonPath(), json_encode('not an array'));

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    });

    test('validates json file structure', function () {
        /** @var TestCase $this */
        $validData = [
            '1' => [
                'id' => 1,
                'name' => 'Test Item',
                'status' => 'active',
            ],
        ];

        File::put($this->sushiJsonPath(), json_encode($validData));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsArray($rows);
        Assert::assertArrayHasKey('1', $rows);
        Assert::assertArrayHasKey('id', \sushiRowById($rows, 1));
        Assert::assertArrayHasKey('name', \sushiRowById($rows, 1));
        Assert::assertArrayHasKey('status', \sushiRowById($rows, 1));
    });
});

describe('Business Logic Tests', function () {
    test('handles large datasets efficiently', function () {
        /** @var TestCase $this */
        $largeData = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeData[(string) $i] = [
                'id' => $i,
                'name' => "Item {$i}",
                'status' => ($i % 2) === 0 ? 'active' : 'inactive',
                'created_at' => now()->toISOString(),
            ];
        }

        File::put($this->sushiJsonPath(), json_encode($largeData));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertCount(1000, $rows);
        Assert::assertSame('Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Item 1000', \sushiRowById($rows, 1000)['name']);
    });

    test('preserves data types correctly', function () {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1, // integer
                'name' => 'Test Item', // string
                'active' => true, // boolean
                'price' => 19.99, // float
                'metadata' => ['key' => 'value'], // array
                'created_at' => '2024-01-01T10:00:00Z', // string datetime
            ],
        ];

        File::put($this->sushiJsonPath(), json_encode($testData));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsInt(\sushiRowById($rows, 1)['id']);
        Assert::assertIsString(\sushiRowById($rows, 1)['name']);
        Assert::assertIsBool(\sushiRowById($rows, 1)['active']);
        Assert::assertIsFloat(\sushiRowById($rows, 1)['price']);
        Assert::assertIsArray(\sushiRowById($rows, 1)['metadata']);
        Assert::assertIsString(\sushiRowById($rows, 1)['created_at']);
    });
});
