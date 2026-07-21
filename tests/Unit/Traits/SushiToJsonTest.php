<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Traits;

<<<<<<< HEAD
use Exception;
=======
>>>>>>> provtv/dev
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Mockery;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;

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
    $this->model = new TestSushiModel();
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

<<<<<<< HEAD
it('returns correct json file path', function (): void {
    $expectedPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
    $actualPath = $this->sushiModel()->getJsonFile();
=======
it('returns correct json file path', function(): void {
    $expectedPath = TenantService::filePath('database/content/test_sushi.json');
    $actualPath = $this->model->getJsonFile();
>>>>>>> provtv/dev

    expect($actualPath)->toBe($expectedPath);
});

<<<<<<< HEAD
it('returns empty array when json file not exists', function (): void {
    $rows = $this->sushiModel()->getSushiRows();
=======
it('returns empty array when json file not exists', function(): void {
    $rows = $this->model->getSushiRows();
>>>>>>> provtv/dev

    expect($rows)->toBe([]);
});

<<<<<<< HEAD
it('throws exception when json data is invalid', function (): void {
    writeSushiJsonFile($this->sushiJsonPath(), []);
=======
it('throws exception when json data is invalid', function(): void {
    // Crea un file JSON con dati non validi
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, 'invalid json content');
>>>>>>> provtv/dev

    File::put($this->sushiJsonPath(), 'invalid json content');

    expect(fn () => $this->sushiModel()->getSushiRows())
        ->toThrow(Exception::class, 'Data is not array ['.$this->sushiJsonPath().']');
});

it('loads valid json data correctly', function(): void {
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

    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
});

it('normalizes nested arrays in json data', function(): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item',
            'metadata' => ['nested' => ['deep' => 'value']],
            'tags' => ['tag1', 'tag2'],
        ],
    ];

    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();
    $row = $this->jsonRecordAt($rows, '1');

    expect($row['metadata'])->toBeString();
    expect($row['tags'])->toBeString();
    expect(json_decode((string) $row['metadata'], true))->toBe(['nested' => ['deep' => 'value']]);
    expect(json_decode((string) $row['tags'], true))->toBe(['tag1', 'tag2']);
});

it('saves data to json file successfully', function(): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Test Item'],
        '2' => ['id' => 2, 'name' => 'Another Item'],
    ];

    $result = $this->sushiModel()->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();

    $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());

    expect($savedData)->toBe($testData);
});

it('creates directory if not exists when saving', function(): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Test']];

    $result = $this->sushiModel()->saveToJson($testData);

    expect($result)->toBeTrue();
    expect(File::exists(dirname($this->sushiJsonPath())))->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();
});

<<<<<<< HEAD
it('returns false when saving fails', function (): void {
    File::shouldReceive('put')->once()->andReturn(false);
=======
it('returns false when saving fails', function(): void {
    // Mock del metodo getJsonFile per simulare un errore
    $mockModel = Mockery::mock(TestSushiModel::class)->makePartial();
    $mockModel->shouldReceive('getJsonFile')->andReturn('/invalid/path/that/cannot/be/created');
>>>>>>> provtv/dev

    $result = $this->sushiModel()->saveToJson(['1' => ['id' => 1, 'name' => 'Test']]);

    expect($result)->toBeFalse();
});

it('loads existing data correctly', function(): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $existingData = $this->sushiModel()->loadExistingData();

    expect($existingData)->toBe($testData);
});

<<<<<<< HEAD
it('returns empty array when no existing data', function (): void {
    $existingData = $this->sushiModel()->loadExistingData();
=======
it('returns empty array when no existing data', function(): void {
    $existingData = $this->model->loadExistingData();
>>>>>>> provtv/dev

    expect($existingData)->toBe([]);
});

<<<<<<< HEAD
it('works with sushi package integration', function (): void {
=======
it('returns next available id correctly', function(): void {
    // Test con dati esistenti
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item 1'],
        '5' => ['id' => 5, 'name' => 'Item 5'],
        '10' => ['id' => 10, 'name' => 'Item 10'],
    ];

    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $nextId = $this->model->getNextId();

    expect($nextId)->toBe(11);
});

it('returns id 1 when no existing data', function(): void {
    $nextId = $this->model->getNextId();

    expect($nextId)->toBe(1);
});

it('returns auth id when user is authenticated', function(): void {
    $user = Mockery::mock('stdClass');
    $user->id = 123;

    Auth::shouldReceive('id')->once()->andReturn(123);

    $authId = $this->model->getAuthId();

    expect($authId)->toBe(123);
});

it('returns null when user is not authenticated', function(): void {
    Auth::shouldReceive('id')->once()->andReturn(null);

    $authId = $this->model->getAuthId();

    expect($authId)->toBeNull();
});

it('handles creating event correctly', function(): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Existing Item'],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Mock dell'utente autenticato
    $user = Mockery::mock('stdClass');
    $user->id = 456;
    Auth::shouldReceive('id')->andReturn(456);

    // Crea un nuovo modello
    $newModel = new TestSushiModel;
    $newModel->name = 'New Item';
    $newModel->description = 'New Description';

    // Simula l'evento creating
    $newModel->fireModelEvent('creating');

    // Verifica che i dati siano stati salvati nel file JSON
    expect(File::exists($this->testJsonPath))->toBeTrue();

    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);

    expect($savedData)->toHaveKey('2'); // Nuovo ID dovrebbe essere 2
    expect($savedData['2']['name'])->toBe('New Item');
    expect($savedData['2']['created_by'])->toBe(456);
    expect($savedData['2']['updated_by'])->toBe(456);
});

it('handles updating event correctly', function(): void {
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
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Mock dell'utente autenticato
    $user = Mockery::mock('stdClass');
    $user->id = 789;
    Auth::shouldReceive('id')->andReturn(789);

    // Carica il modello esistente
    $existingModel = new TestSushiModel;
    $existingModel->id = 1;
    $existingModel->name = 'Updated Name';
    $existingModel->description = 'Updated Description';

    // Simula l'evento updating
    $existingModel->fireModelEvent('updating');

    // Verifica che i dati siano stati aggiornati nel file JSON
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);

    expect($savedData['1']['name'])->toBe('Updated Name');
    expect($savedData['1']['description'])->toBe('Updated Description');
    expect($savedData['1']['updated_by'])->toBe(789);
});

it('handles deleting event correctly', function(): void {
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item to Delete'],
        '2' => ['id' => 2, 'name' => 'Item to Keep'],
    ];

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    // Carica il modello da eliminare
    $modelToDelete = new TestSushiModel;
    $modelToDelete->id = 1;

    // Simula l'evento deleting
    $modelToDelete->fireModelEvent('deleting');

    // Verifica che il record sia stato rimosso dal file JSON
    $savedContent = File::get($this->testJsonPath);
    $savedData = json_decode($savedContent, true);

    expect($savedData)->not->toHaveKey('1');
    expect($savedData)->toHaveKey('2');
    expect($savedData['2']['name'])->toBe('Item to Keep');
});

it('works with sushi package integration', function(): void {
>>>>>>> provtv/dev
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

    writeSushiJsonFile($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toBe($testData);
    expect($rows)->toHaveCount(2);
    expect($this->jsonRecordAt($rows, '1')['name'])->toBe('Sushi Item 1');
    expect($this->jsonRecordAt($rows, '2')['name'])->toBe('Sushi Item 2');
});
