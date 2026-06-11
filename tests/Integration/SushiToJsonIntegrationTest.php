<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

uses(TestCase::class);

function tenantJsonPath(string $tenantName): string
{
    $dir = storage_path('tests/sushi-json/'.$tenantName);
    if (! File::exists($dir)) {
        File::makeDirectory($dir, 0o755, true, true);
    }

    return $dir.'/test_sushi.json';
}

function makeTestSushiModelForPath(string $jsonPath): TestSushiModel
{
    $model = new class extends TestSushiModel
    {
        public string $jsonPath = '';

        public function setJsonPath(string $jsonPath): void
        {
            $this->jsonPath = $jsonPath;
        }

        public function getJsonFile(): string
        {
            return $this->jsonPath;
        }
    };

    $model->setJsonPath($jsonPath);

    return $model;
}

describe('SushiToJson integration', function (): void {
    beforeEach(function (): void {
        /** @var TestCase $this */
        $root = storage_path('tests/sushi-json');
        if (File::exists($root)) {
            File::deleteDirectory($root);
        }
    });

    afterEach(function (): void {
        /** @var TestCase $this */
        $root = storage_path('tests/sushi-json');
        if (File::exists($root)) {
            File::deleteDirectory($root);
        }
    });

    test('creates json file with tenant isolation', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $tenant2Path = tenantJsonPath('tenant2');

        $model1 = makeTestSushiModelForPath($tenant1Path);
        $model2 = makeTestSushiModelForPath($tenant2Path);

        $model1->saveToJson([
            '1' => [
                'id' => 1,
                'name' => 'Tenant 1 Item',
                'description' => 'Item specifico per tenant 1',
                'status' => 'active',
            ],
        ]);

        Assert::assertTrue(File::exists($tenant1Path));
        Assert::assertFalse(File::exists($tenant2Path));
        $model2->saveToJson([
            '1' => [
                'id' => 1,
                'name' => 'Tenant 2 Item',
                'description' => 'Item specifico per tenant 2',
                'status' => 'active',
            ],
        ]);

        Assert::assertTrue(File::exists($tenant2Path));
        $tenant1Data = json_decode(File::get($tenant1Path), true);
        Assert::assertIsArray($tenant1Data);
        $tenant2Data = json_decode(File::get($tenant2Path), true);

        Assert::assertIsArray($tenant2Data);

        $tenant1ById = collect($tenant1Data)->keyBy('id');
        $tenant2ById = collect($tenant2Data)->keyBy('id');

        Assert::assertArrayHasKey(1, $tenant1ById->all());
        Assert::assertArrayHasKey(1, $tenant2ById->all());
        $tenant1Row = $tenant1ById->get(1);
        $tenant2Row = $tenant2ById->get(1);
        Assert::assertIsArray($tenant1Row);
        Assert::assertIsArray($tenant2Row);
        Assert::assertSame('Tenant 1 Item', $tenant1Row['name']);
        Assert::assertSame('Tenant 2 Item', $tenant2Row['name']);
    });

    test('loads data with tenant isolation', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $tenant2Path = tenantJsonPath('tenant2');

        $model1 = makeTestSushiModelForPath($tenant1Path);
        $model2 = makeTestSushiModelForPath($tenant2Path);

        $model1->saveToJson([
            '1' => ['id' => 1, 'name' => 'Tenant 1 Item 1', 'status' => 'active'],
            '2' => ['id' => 2, 'name' => 'Tenant 1 Item 2', 'status' => 'active'],
        ]);
        $model2->saveToJson([
            '1' => ['id' => 1, 'name' => 'Tenant 2 Item 1', 'status' => 'active'],
            '2' => ['id' => 2, 'name' => 'Tenant 2 Item 2', 'status' => 'active'],
        ]);

        $rows1 = $model1->getSushiRows();
        $rows2 = $model2->getSushiRows();
        $rows1ById = collect($rows1)->keyBy('id');
        $rows2ById = collect($rows2)->keyBy('id');

        Assert::assertCount(2, $rows1ById);
        Assert::assertCount(2, $rows2ById);
        $row1 = $rows1ById->get(1);
        $row2 = $rows2ById->get(1);
        Assert::assertIsArray($row1);
        Assert::assertIsArray($row2);
        Assert::assertSame('Tenant 1 Item 1', $row1['name']);
        Assert::assertSame('Tenant 2 Item 1', $row2['name']);
        Assert::assertNotSame($rows2ById, $rows1ById);
    });

    test('handles complex data structures', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $model = makeTestSushiModelForPath($tenant1Path);

        $complexData = [
            '1' => [
                'id' => 1,
                'name' => 'Complex Item',
                'metadata' => [
                    'tags' => ['tag1', 'tag2', 'tag3'],
                    'settings' => [
                        'enabled' => true,
                        'max_retries' => 3,
                        'timeout' => 30.5,
                    ],
                    'nested' => [
                        'level1' => [
                            'level2' => [
                                'level3' => 'deep_value',
                            ],
                        ],
                    ],
                ],
                'status' => 'active',
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ],
        ];

        Assert::assertTrue($model->saveToJson($complexData));
        $loadedData = $model->getSushiRows();
        $rowsById = collect($loadedData)->keyBy('id');

        $complexRow = $rowsById->get(1);
        Assert::assertIsArray($complexRow);
        Assert::assertSame('Complex Item', $complexRow['name']);
        Assert::assertIsString($complexRow['metadata']);
        $metadata = json_decode($complexRow['metadata'], true);
        Assert::assertIsArray($metadata);
        Assert::assertSame(['tag1', 'tag2', 'tag3'], $metadata['tags']);
        $settings = $metadata['settings'] ?? null;
        Assert::assertIsArray($settings);
        Assert::assertSame(30.5, $settings['timeout']);
        $nested = $metadata['nested'] ?? null;
        Assert::assertIsArray($nested);
        $level1 = $nested['level1'] ?? null;
        Assert::assertIsArray($level1);
        $level2 = $level1['level2'] ?? null;
        Assert::assertIsArray($level2);
        Assert::assertSame('deep_value', $level2['level3']);
    });

    test('handles concurrent access safely', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $model = makeTestSushiModelForPath($tenant1Path);

        $model->saveToJson([
            '1' => ['id' => 1, 'name' => 'Initial Item', 'status' => 'active'],
        ]);

        Assert::assertTrue($model->saveToJson([
            '1' => ['id' => 1, 'name' => 'Concurrent Update', 'status' => 'updated'],
            '2' => ['id' => 2, 'name' => 'New Item', 'status' => 'active'],
        ]));
        $loaded = $model->getSushiRows();
        $rowsById = collect($loaded)->keyBy('id');

        Assert::assertCount(2, $rowsById);
        $concurrentRow = $rowsById->get(1);
        Assert::assertIsArray($concurrentRow);
        Assert::assertSame('Concurrent Update', $concurrentRow['name']);
        $newRow = $rowsById->get(2);
        Assert::assertIsArray($newRow);
        Assert::assertSame('New Item', $newRow['name']);
    });

    test('handles large datasets efficiently', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $model = makeTestSushiModelForPath($tenant1Path);

        $largeData = [];
        for ($i = 1; $i <= 500; $i++) {
            $largeData[(string) $i] = [
                'id' => $i,
                'name' => "Large Dataset Item {$i}",
                'description' => "Description for large dataset item {$i}",
                'status' => 0 === ($i % 2) ? 'active' : 'inactive',
                'metadata' => [
                    'category' => 'Category '.($i % 10),
                    'priority' => ($i % 5) + 1,
                    'tags' => ["tag{$i}", 'tag'.($i + 1)],
                ],
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString(),
            ];
        }

        Assert::assertTrue($model->saveToJson($largeData));
        Assert::assertCount(500, $model->getSushiRows());
    });

    test('handles unicode and special characters', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $model = makeTestSushiModelForPath($tenant1Path);

        Assert::assertTrue($model->saveToJson([
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ', '中文标签', '🚀-tag'],
                'metadata' => [
                    'special_chars' => 'áéíóú ñ ü ç',
                    'emojis' => ['🎉', '🚀', '⭐', '🔥', '💯'],
                    'chinese' => '你好世界',
                    'japanese' => 'こんにちは世界',
                ],
            ],
        ]));
        $loaded = $model->getSushiRows();
        $rowsById = collect($loaded)->keyBy('id');

        $unicodeRow = $rowsById->get(1);
        Assert::assertIsArray($unicodeRow);
        Assert::assertSame('Café & Résumé 🚀', $unicodeRow['name']);
        Assert::assertSame('Test con caratteri speciali: é, è, ñ, 中文, 🎉', $unicodeRow['description']);
    });

    test('handles empty and null values', function (): void {
        /** @var TestCase $this */
        $tenant1Path = tenantJsonPath('tenant1');
        $model = makeTestSushiModelForPath($tenant1Path);

        Assert::assertTrue($model->saveToJson([
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'tags' => null,
                'settings' => [
                    'enabled' => false,
                    'max_retries' => 0,
                    'timeout' => 0.0,
                    'empty_string' => '',
                    'null_value' => null,
                    'empty_array' => [],
                ],
                'status' => false,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]));
        $loaded = $model->getSushiRows();
        $rowsById = collect($loaded)->keyBy('id');

        $emptyRow = $rowsById->get(1);
        Assert::assertIsArray($emptyRow);
        Assert::assertSame('', $emptyRow['name']);
        Assert::assertNull($emptyRow['description']);
    });

    test('works with different tenant configurations', function (): void {
        /** @var TestCase $this */
        $customDir = storage_path('tests/sushi-json/custom-tenant');
        if (! File::exists($customDir)) {
            File::makeDirectory($customDir, 0o755, true, true);
        }

        $model = makeTestSushiModelForPath($customDir.'/test_sushi.json');

        Assert::assertTrue($model->saveToJson([
            '1' => [
                'id' => 1,
                'name' => 'Custom Tenant Item',
                'status' => 'active',
            ],
        ]));
        Assert::assertTrue(File::exists($customDir.'/test_sushi.json'));
    });
});
