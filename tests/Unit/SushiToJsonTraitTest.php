<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

<<<<<<< HEAD
use Exception;
=======
>>>>>>> provtv/dev
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class);

<<<<<<< HEAD
beforeEach(function (): void {
    $this->model = new TestSushiModel();
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

=======
/**
 * Test unitari per il trait SushiToJson.
 *
 * Testa tutte le funzionalità del trait in isolamento,
 * utilizzando mock per le dipendenze esterne.
 */
beforeEach(function(): void {
    // Configura il modello di test
    $this->model = new TestSushiModel;

    // Configura percorsi di test
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    // Crea directory di test
>>>>>>> provtv/dev
    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
    }

<<<<<<< HEAD
    $jsonPath = $this->testJsonPath;
    $mock = Mockery::mock(GetTenantFilePathAction::class);
    tenantMockExpectation($mock, 'execute')
        ->with('database/content/test_sushi.json')
        ->andReturn($jsonPath);
    app()->instance(GetTenantFilePathAction::class, $mock);
=======
    // Mock TenantService per i test
    $this->mock(TenantService::class, function ($mock): void {
        $mock->shouldReceive('filePath')->with('database/content/test_sushi.json')->andReturn($this->testJsonPath);
    });
>>>>>>> provtv/dev

    $this->createTestData = static fn (): array => [
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

<<<<<<< HEAD
afterEach(function (): void {
=======
afterEach(function(): void {
    // Cleanup file di test
>>>>>>> provtv/dev
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
    }

    if (File::exists($this->testDirectory)) {
        File::deleteDirectory($this->testDirectory);
    }

    Mockery::close();
});

describe('SushiToJson Trait', function (): void {
    it('returns correct json file path', function (): void {
<<<<<<< HEAD
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
    });

    it('loads existing data from json file', function (): void {
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->loadExistingData();

        expect($rows)->toBeArray()->toHaveCount(2);
        expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Test Item 1');
        expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function (): void {
        expect($this->sushiModel()->getSushiRows())->toBeArray()->toBeEmpty();
=======
        $path = $this->model->getJsonFile();

        expect($path)->toBe($this->testJsonPath)->and($path)->toEndWith('test_sushi.json');
    });

    it('loads existing data from json file', function (): void {
        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->model->loadExistingData();

        expect($rows)
            ->toBeArray()
            ->toHaveCount(2)
            ->and($rows['1']['name'])
            ->toBe('Test Item 1')
            ->and($rows['2']['name'])
            ->toBe('Test Item 2');
    });

    it('returns empty array when file not exists', function (): void {
        $rows = $this->model->getSushiRows();

        expect($rows)->toBeArray()->toBeEmpty();
>>>>>>> provtv/dev
    });

    it('throws exception with malformed json', function (): void {
        File::put($this->testJsonPath, 'invalid json content');

<<<<<<< HEAD
        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Syntax error');
=======
        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Syntax error');
>>>>>>> provtv/dev
    });

    it('throws exception with non array data', function (): void {
        File::put($this->testJsonPath, '"string data"');

<<<<<<< HEAD
        expect(fn () => $this->sushiModel()->getSushiRows())
            ->toThrow(Exception::class, 'Data is not array');
=======
        expect($this->model->getSushiRows(...))->toThrow(Exception::class, 'Data is not array');
>>>>>>> provtv/dev
    });

    it('normalizes nested arrays to json strings', function(): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Test',
                'metadata' => ['nested' => 'value'],
                'tags' => ['tag1', 'tag2'],
            ],
        ];

        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

<<<<<<< HEAD
        $rows = $this->sushiModel()->getSushiRows();
        $row = $this->jsonRecordAt($rows, '1');

        expect($row['metadata'])->toBeString()->toBe('{"nested":"value"}');
        expect($row['tags'])->toBeString()->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function (): void {
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
        expect($this->testJsonPath)->toBeFile();

        expect($this->readJsonFileAsArray($this->testJsonPath))->toBe($testData);
    });

    it('creates directory if not exists', function (): void {
=======
        $rows = $this->model->getSushiRows();

        expect($rows['1']['metadata'])
            ->toBeString()
            ->toBe('{"nested":"value"}')
            ->and($rows['1']['tags'])
            ->toBeString()
            ->toBe('["tag1","tag2"]');
    });

    it('saves data successfully to json file', function (): void {
        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
        expect($this->testJsonPath)->toBeFile();

        $savedData = json_decode(File::get($this->testJsonPath), true);
        expect($savedData)->toBe($testData);
    });

    it('creates directory if not exists', function(): void {
        // Rimuovi directory di test
>>>>>>> provtv/dev
        if (File::exists($this->testDirectory)) {
            File::deleteDirectory($this->testDirectory);
        }

<<<<<<< HEAD
        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
=======
        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeTrue();
>>>>>>> provtv/dev
        expect($this->testDirectory)->toBeDirectory();
        expect($this->testJsonPath)->toBeFile();
    });

<<<<<<< HEAD
    it('handles save errors gracefully', function (): void {
        File::shouldReceive('put')->once()->andReturn(false);

        /** @var array<int, array<string, mixed>> $testData */
        $testData = $this->sushiTestData();

        expect($this->sushiModel()->saveToJson($testData))->toBeFalse();
    });

    it('handles creating event correctly', function (): void {
=======
    it('handles save errors gracefully', function(): void {
        // Mock File facade per simulare errore di scrittura
        File::shouldReceive('put')->once()->andReturn(false);

        $testData = ($this->createTestData)();

        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('handles creating event correctly', function(): void {
        // Mock Auth per simulare utente autenticato
>>>>>>> provtv/dev
        Auth::shouldReceive('id')->andReturn(1);

        $model = new TestSushiModel();
        $model->fill(['name' => 'New Item', 'description' => 'New Description']);

<<<<<<< HEAD
        expect($model->name)->toBe('New Item');
        expect($model->getJsonFile())->toBeString()->toEndWith('test_sushi.json');
    });

    it('integrates with tenant service correctly', function (): void {
        expect(app(GetTenantFilePathAction::class))->toBeInstanceOf(GetTenantFilePathAction::class);
        expect($this->sushiModel()->getJsonFile())->toBe($this->testJsonPath);
    });

    it('handles large datasets efficiently', function (): void {
=======
        $model = new TestSushiModel;
        $model->fill($testData);

        // Test che il modello può essere creato con i dati
        expect($model->name)->toBe('New Item')->and($model->description)->toBe('New Description');

        // Test che i metodi del trait funzionano
        expect($model->getJsonFile())->toBeString()->toEndWith('test_sushi.json');
    });

    it('handles updating event correctly', function(): void {
        // Mock Auth per simulare utente autenticato
        Auth::shouldReceive('id')->andReturn(1);

        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;
        $model->fill(['name' => 'Updated Name']);

        // Test che il modello può essere aggiornato
        expect($model->name)->toBe('Updated Name')->and($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        expect($existingData)->toHaveKey('1')->and($existingData['1']['name'])->toBe('Test Item 1');
    });

    it('handles deleting event correctly', function (): void {
        $testData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

        $model = new TestSushiModel;
        $model->id = 1;

        // Test che il modello può essere configurato per la cancellazione
        expect($model->id)->toBe(1);

        // Test che i dati esistenti possono essere caricati
        $existingData = $model->loadExistingData();
        expect($existingData)->toHaveKey('1')->toHaveKey('2');

        // Test che il metodo saveToJson funziona
        $result = $model->saveToJson($existingData);
        expect($result)->toBeTrue();
    });

    it('integrates with tenant service correctly', function(): void {
        $tenantService = app(TenantService::class);

        expect($tenantService)->toBeInstanceOf(TenantService::class);

        // Verifica che il mock funzioni correttamente
        $path = $this->model->getJsonFile();
        expect($path)->toBe($this->testJsonPath);
    });

    it('handles large datasets efficiently', function(): void {
        // Crea dataset grande (1000 record)
>>>>>>> provtv/dev
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
        expect(microtime(true) - $startTime)->toBeLessThan(1.0);

<<<<<<< HEAD
        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
        expect(microtime(true) - $startTime)->toBeLessThan(0.5);
        expect($rows)->toHaveCount(1000);
    });

    it('maintains data integrity during operations', function (): void {
        /** @var array<int, array<string, mixed>> $originalData */
        $originalData = $this->sushiTestData();
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        expect($this->sushiModel()->loadExistingData())->toBe($originalData);
=======
        $result = $this->model->saveToJson($largeData);

        $endTime = microtime(true);
        $executionTime = $endTime - $startTime;

        expect($result)->toBeTrue();
        expect($executionTime)->toBeLessThan(1.0);

        // Verifica caricamento
        $startTime = microtime(true);
        $rows = $this->model->getSushiRows();
        $endTime = microtime(true);
        $loadTime = $endTime - $startTime;

        expect($rows)->toHaveCount(1000);
        expect($loadTime)->toBeLessThan(0.5);
    });

    it('logs errors appropriately', function(): void {
        // Mock Log facade per verificare logging
        $this->mock('log', function ($mock): void {
            $mock->shouldReceive('error')->once()->with('Failed to save data to JSON file', Mockery::any());
        });

        // Simula errore di salvataggio
        File::shouldReceive('put')->once()->andReturn(false);

        $testData = ($this->createTestData)();
        $result = $this->model->saveToJson($testData);

        expect($result)->toBeFalse();
    });

    it('maintains data integrity during operations', function (): void {
        $originalData = ($this->createTestData)();
        File::put($this->testJsonPath, json_encode($originalData, JSON_PRETTY_PRINT));

        // Verifica che i dati originali siano preservati
        $loadedData = $this->model->loadExistingData();
        expect($loadedData)->toBe($originalData);
>>>>>>> provtv/dev

        $updatedData = $originalData;
<<<<<<< HEAD
        $updatedData[1]['name'] = 'Updated Name';

        expect($this->sushiModel()->saveToJson($updatedData))->toBeTrue();

        $finalData = $this->sushiModel()->loadExistingData();
        expect($this->jsonRecordAt($finalData, 1)['name'])->toBe('Updated Name');
        expect($this->jsonRecordAt($finalData, 2)['name'])->toBe('Test Item 2');
=======
        $updatedData['1']['name'] = 'Updated Name';

        $result = $this->model->saveToJson($updatedData);
        expect($result)->toBeTrue();

        // Verifica che solo il record specifico sia stato aggiornato
        $finalData = $this->model->loadExistingData();
        expect($finalData['1']['name'])->toBe('Updated Name')->and($finalData['2']['name'])->toBe('Test Item 2'); // Non modificato
    });

    it('handles empty and null values correctly', function(): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => '',
                'description' => null,
                'metadata' => [],
                'status' => false,
            ],
        ];

        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        $loadedData = $this->model->getSushiRows();
        expect($loadedData['1']['name'])
            ->toBe('')
            ->and($loadedData['1']['description'])
            ->toBeNull()
            ->and($loadedData['1']['metadata'])
            ->toBe('[]') // Convertito in stringa JSON
            ->and($loadedData['1']['status'])
            ->toBeFalse();
    });

    it('handles unicode and special characters', function(): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Café & Résumé 🚀',
                'description' => 'Test con caratteri speciali: é, è, ñ, 中文, 🎉',
                'tags' => ['tag-é', 'tag-è', 'tag-ñ'],
            ],
        ];

        $result = $this->model->saveToJson($testData);
        expect($result)->toBeTrue();

        $loadedData = $this->model->getSushiRows();
        expect($loadedData['1']['name'])
            ->toBe('Café & Résumé 🚀')
            ->and($loadedData['1']['description'])
            ->toBe('Test con caratteri speciali: é, è, ñ, 中文, 🎉')
            ->and($loadedData['1']['tags'])
            ->toBe('["tag-é","tag-è","tag-ñ"]');
>>>>>>> provtv/dev
    });
});
