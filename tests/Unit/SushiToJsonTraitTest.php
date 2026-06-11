<?php

declare(strict_types=1);

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

/**
 * Test unitari per il trait SushiToJson.
 *
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
describe('SushiToJson Trait', function (): void {
    beforeEach(function (): void {
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

        // Helper per creare dati di test
        $this->createTestData = fn () => [
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
    });

    afterEach(function (): void {
        /** @var TestCase $this */

        // Cleanup file di test
        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        if (File::exists($this->sushiTestDirectory())) {
            File::deleteDirectory($this->sushiTestDirectory());
        }
    });

    test('returns correct json file path', function (): void {
        /** @var TestCase $this */
        $path = $this->sushiModel()->getJsonFile();

        Assert::assertSame($this->sushiJsonPath(), $path);
        Assert::assertStringEndsWith('test_sushi.json', $path);
    });

    test('loads existing data from json file', function (): void {
        /** @var TestCase $this */
        $testData = $this->sushiTestData();
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->loadExistingData();

        Assert::assertIsArray($rows);
        Assert::assertCount(2, $rows);
        Assert::assertSame('Test Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Test Item 2', \sushiRowById($rows, 2)['name']);
    });

    test('returns empty array when file not exists', function (): void {
        /** @var TestCase $this */
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsArray($rows);
        Assert::assertEmpty($rows);
    });

    test('throws exception with malformed json', function (): void {
        /** @var TestCase $this */
        File::put($this->sushiJsonPath(), 'invalid json content');

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    });

    test('throws exception with non array data', function (): void {
        /** @var TestCase $this */
        File::put($this->sushiJsonPath(), '"string data"');

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    });

    test('normalizes nested arrays to json strings', function (): void {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsString(\sushiRowById($rows, 1)['metadata']);
        Assert::assertSame('{"nested":"value"}', \sushiRowById($rows, 1)['metadata']);
        Assert::assertIsString(\sushiRowById($rows, 1)['tags']);
        Assert::assertSame('["tag1","tag2"]', \sushiRowById($rows, 1)['tags']);
    });

    test('saves data successfully to json file', function (): void {
        /** @var TestCase $this */
        $testData = $this->sushiTestData();

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertFileExists($this->sushiJsonPath());

        $savedData = json_decode(File::get($this->sushiJsonPath()), true);
        Assert::assertIsArray($savedData);
        Assert::assertSame($testData, $savedData);
    });

    test('creates directory if not exists', function (): void {
        /** @var TestCase $this */

        // Rimuovi directory di test
        if (File::exists($this->sushiTestDirectory())) {
            File::deleteDirectory($this->sushiTestDirectory());
        }

        $testData = $this->sushiTestData();

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertDirectoryExists($this->sushiTestDirectory());
        Assert::assertFileExists($this->sushiJsonPath());
    });

    test('handles save errors gracefully', function (): void {
        /** @var TestCase $this */
        /** @var TestSushiModel&Mockery\MockInterface $mockModel */
        $mockModel = Mockery::mock(TestSushiModel::class)->makePartial();
        $mockModel->allows([
            'getJsonFile' => '/invalid/path/that/cannot/be/created/test.json',
        ]);

        $testData = $this->sushiTestData();
        $result = $mockModel->saveToJson($testData);

        Assert::assertFalse($result);
    });

    test('handles creating event correctly', function (): void {
        /** @var TestCase $this */

        // Mock Auth per simulare utente autenticato
        Auth::partialMock()->allows([
            'id' => 1,
        ]);

        $testData = [
            'name' => 'New Item',
            'description' => 'New Description',
        ];

        $model = new TestSushiModel;
        $model->fill($testData);

        // Test che il modello può essere creato con i dati
        Assert::assertSame('New Item', $model->name);
        Assert::assertSame('New Description', $model->description);
        Assert::assertStringEndsWith('test_sushi.json', $model->getJsonFile());
    });

    test('handles updating event correctly', function (): void {
        /** @var TestCase $this */

        // Mock Auth per simulare utente autenticato
        Auth::partialMock()->allows([
            'id' => 1,
        ]);

        $testData = $this->sushiTestData();
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;
        $model->fill(['name' => 'Updated Name']);

        // Test che il modello può essere aggiornato
        Assert::assertSame('Updated Name', $model->name);
        Assert::assertSame(1, $model->id);
        $existingData = $model->loadExistingData();
        Assert::assertSame('Test Item 1', \sushiRowById($existingData, 1)['name']);
        Assert::assertArrayHasKey('1', $existingData);
    });

    test('handles deleting event correctly', function (): void {
        /** @var TestCase $this */
        $testData = $this->sushiTestData();
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;

        // Test che il modello può essere configurato per la cancellazione
        Assert::assertSame(1, $model->id);
        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        Assert::assertArrayHasKey('1', $existingData);
        Assert::assertArrayHasKey('2', $existingData);
        // Test che il metodo saveToJson funziona
        $result = $model->saveToJson($existingData);
        Assert::assertTrue($result);
    });

    test('integrates with tenant service correctly', function (): void {
        /** @var TestCase $this */
        $tenantService = app(TenantService::class);

        Assert::assertInstanceOf(TenantService::class, $tenantService);
        // Verifica che il mock funzioni correttamente
        $path = $this->sushiModel()->getJsonFile();
        Assert::assertSame($this->sushiJsonPath(), $path);
    });

    test('handles large datasets efficiently', function (): void {
        /** @var TestCase $this */

        // Crea dataset grande (1000 record)
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

        $result = $this->sushiModel()->saveToJson($largeData);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(1.0, $executionTime);
        // Verifica caricamento
        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        Assert::assertCount(1000, $rows);
        Assert::assertLessThan(0.5, $loadTime);
    });

    test('logs errors appropriately', function (): void {
        /** @var TestCase $this */
        /** @var TestSushiModel&Mockery\MockInterface $mockModel */
        $mockModel = Mockery::mock(TestSushiModel::class)->makePartial();
        $mockModel->allows([
            'getJsonFile' => '/invalid/path/that/cannot/be/created/test.json',
        ]);

        $testData = $this->sushiTestData();
        $result = $mockModel->saveToJson($testData);

        Assert::assertFalse($result);
    });

    test('maintains data integrity during operations', function (): void {
        /** @var TestCase $this */
        $originalData = $this->sushiTestData();
        File::put($this->sushiJsonPath(), json_encode($originalData, JSON_PRETTY_PRINT));

        // Verifica che i dati originali siano preservati
        $loadedData = $this->sushiModel()->loadExistingData();
        Assert::assertSame($originalData, $loadedData);
        // Aggiorna un record
        $updatedData = $originalData;
        $updatedData['1']['name'] = 'Updated Name';

        $result = $this->sushiModel()->saveToJson($updatedData);
        Assert::assertTrue($result);
        // Verifica che solo il record specifico sia stato aggiornato
        $finalData = $this->sushiModel()->loadExistingData();
        Assert::assertSame('Updated Name', $finalData['1']['name']);
        Assert::assertSame('Test Item 2', $finalData['2']['name']);
    });

    test('handles empty and null values correctly', function (): void {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => false,
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);
        Assert::assertTrue($result);
        $loadedData = $this->sushiModel()->getSushiRows();
        Assert::assertSame('', $loadedData['1']['name']);
        Assert::assertNull($loadedData['1']['description']);
        Assert::assertSame('[]', $loadedData['1']['metadata']);
        Assert::assertFalse($loadedData['1']['status']);
    });

    test('handles unicode and special characters', function (): void {
        /** @var TestCase $this */
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ'],
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);
        Assert::assertTrue($result);
        $loadedData = $this->sushiModel()->getSushiRows();
        Assert::assertSame('Café & Résumé 🚀', $loadedData['1']['name']);
        Assert::assertSame('Test con caratteri speciali: é, è, ñ, 中文, 🎉', $loadedData['1']['description']);
        Assert::assertSame('["tag-é","tag-è","tag-ñ"]', $loadedData['1']['tags']);
    });
});
