<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use ReflectionMethod;
use function Safe\json_encode;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(\Modules\Tenant\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Tenant\Tests\TestCase $this */
$this->model = new TestSushiModel;
        $this->testJsonPath = $this->model->getJsonFile();

        // Pulisce eventuali file di test esistenti
        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        // Rimuove la directory se esiste
        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
});

afterEach(function (): void {
// Pulisce i file di test
        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }

        Mockery::close();

});

describe('Sushi To Json', function (): void {
    test('returns correct json file path', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
$expectedPath = storage_path('tests/sushi-json/test_sushi.json');
        $actualPath = $this->sushiModel()->getJsonFile();

        Assert::assertSame($expectedPath, $actualPath);
    });

    test('returns empty array when json file not exists', function (): void {
$rows = $this->sushiModel()->getSushiRows();

        Assert::assertSame([], $rows);
    });

    test('throws exception when json data is invalid', function (): void {
// Crea un file JSON con dati non validi
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), 'invalid json content');

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    });

    test('loads valid json data correctly', function (): void {
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

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame('Test Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Test Item 2', \sushiRowById($rows, 2)['name']);
    });

    test('normalizes nested arrays in json data', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test Item',
                'metadata' => ['nested' => ['deep' => 'value']],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertIsString(\sushiRowById($rows, 1)['metadata']);
        Assert::assertIsString(\sushiRowById($rows, 1)['tags']);
        Assert::assertSame(['nested' => ['deep' => 'value']], $this->decodeJsonString(\sushiRowById($rows, 1)['metadata']));
        Assert::assertSame(['tag1', 'tag2'], $this->decodeJsonString(\sushiRowById($rows, 1)['tags']));
    });

    test('saves data to json file successfully', function (): void {
$testData = [
            '1' => ['id' => 1, 'name' => 'Test Item'],
            '2' => ['id' => 2, 'name' => 'Another Item'],
        ];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

        Assert::assertCount(2, $savedData);
        Assert::assertSame('Test Item', \sushiRowById($savedData, 1)['name']);
        Assert::assertSame('Another Item', \sushiRowById($savedData, 2)['name']);
    });

    test('creates directory if not exists when saving', function (): void {
$testData = ['1' => ['id' => 1, 'name' => 'Test']];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertTrue(File::exists(dirname($this->sushiJsonPath())));
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
    });

    test('returns false when saving fails', function (): void {
// Mock del metodo getJsonFile per simulare un errore
        /** @var TestSushiModel&Mockery\MockInterface $mockModel */
        $mockModel = Mockery::mock(TestSushiModel::class)->makePartial();
        $mockModel->allows([
            'getJsonFile' => '/invalid/path/that/cannot/be/created',
        ]);

        $result = $mockModel->saveToJson(['1' => ['id' => 1, 'name' => 'test']]);

        Assert::assertFalse($result);
    });

    test('loads existing data correctly', function (): void {
$testData = [
            '1' => ['id' => 1, 'name' => 'Existing Item'],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $existingData = $this->sushiModel()->loadExistingData();

        Assert::assertCount(1, $existingData);
        Assert::assertSame('Existing Item', \sushiRowById($existingData, 1)['name']);
    });

    test('returns empty array when no existing data', function (): void {
$existingData = $this->sushiModel()->loadExistingData();

        Assert::assertSame([], $existingData);
    });

    test('returns next available id correctly', function (): void {
// Test con dati esistenti
        $testData = [
            '1' => ['id' => 1, 'name' => 'Item 1'],
            '5' => ['id' => 5, 'name' => 'Item 5'],
            '10' => ['id' => 10, 'name' => 'Item 10'],
        ];

        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $getNextId = new ReflectionMethod(TestSushiModel::class, 'getNextId');
        $nextId = $getNextId->invoke($this->sushiModel());

        Assert::assertSame(11, $nextId);
    });

    test('returns id1when no existing data', function (): void {
$getNextId = new ReflectionMethod(TestSushiModel::class, 'getNextId');
        $nextId = $getNextId->invoke($this->sushiModel());

        Assert::assertSame(1, $nextId);
    });

    test('handles creating event correctly', function (): void {
$testData = [
            '1' => ['id' => 1, 'name' => 'Existing Item'],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        Auth::partialMock()->allows([
            'id' => 456,
        ]);

        $newModel = new TestSushiModel;
        $newModel->name = 'New Item';
        $newModel->description = 'New Description';
        $newModel->save();

        // Verifica che i dati siano stati salvati nel file JSON
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

        $createdRow = \sushiRowById($savedData, 2);
        Assert::assertSame('New Item', $createdRow['name']);
        Assert::assertSame(456, $createdRow['created_by']);
        Assert::assertSame(456, $createdRow['updated_by']);
    });

    test('handles updating event correctly', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Original Name',
                'description' => 'Original Description',
                'created_at' => now()->subDay()->toISOString(),
                'updated_at' => now()->subDay()->toISOString(),
            ],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        Auth::partialMock()->allows([
            'id' => 789,
        ]);

        $existingModel = new TestSushiModel;
        $existingModel->id = 1;
        $existingModel->name = 'Updated Name';
        $existingModel->description = 'Updated Description';
        $existingModel->save();

        // Verifica che i dati siano stati aggiornati nel file JSON
        $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

        $updatedRow = \sushiRowById($savedData, 1);
        Assert::assertSame('Updated Name', $updatedRow['name']);
        Assert::assertSame('Updated Description', $updatedRow['description']);
        Assert::assertSame(789, $updatedRow['updated_by']);
    });

    test('handles deleting event correctly', function (): void {
$testData = [
            '1' => ['id' => 1, 'name' => 'Item to Delete'],
            '2' => ['id' => 2, 'name' => 'Item to Keep'],
        ];

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $modelToDelete = new TestSushiModel;
        $modelToDelete->id = 1;
        $modelToDelete->delete();

        // Verifica che il record sia stato rimosso dal file JSON
        $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

        Assert::assertNull(collect($savedData)->firstWhere('id', 1));
        $keptRow = \sushiRowById($savedData, 2);
        Assert::assertSame('Item to Keep', $keptRow['name']);
    });

    test('works with sushi package integration', function (): void {
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

        // Crea il file JSON di test
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        // Testa l'integrazione con Sushi
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertCount(2, $rows);
        Assert::assertSame('Sushi Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Sushi Item 2', \sushiRowById($rows, 2)['name']);
    });
});
