<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration\Traits;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;

use function Safe\json_encode;

uses(TestCase::class, DatabaseTransactions::class);

/**
 * @param  array<array-key, mixed>  $data
 */
function writeTraitIntegrationJson(string $path, array $data): void
{
    $directory = dirname($path);
    File::makeDirectory($directory, 0755, true, true);
    File::put($path, json_encode($data, JSON_PRETTY_PRINT));
}

beforeEach(function (): void {
    $this->tenant = createTenant([
        'name' => 'test-tenant',
        'domain' => 'test.example.com',
    ]);

    $this->setCurrentTenant($this->tenantModel());

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
});

it('creates json file with tenant isolation', function(): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Tenant Specific Item',
            'tenant_id' => $this->tenantId(),
        ],
    ];

    expect($this->sushiModel()->saveToJson($testData))->toBeTrue();
    expect(File::exists($this->sushiJsonPath()))->toBeTrue();
    expect($this->sushiJsonPath())->toBe(app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json'));

    $savedData = $this->readJsonFileAsArray($this->sushiJsonPath());
    expect($savedData)->toBe($testData);
    expect($this->jsonRecordAt($savedData, '1')['tenant_id'])->toBe($this->tenantId());
});

<<<<<<< HEAD
it('loads data with tenant isolation', function (): void {
    $tenantId = $this->tenantId();
=======
it('loads data with tenant isolation', function(): void {
>>>>>>> provtv/dev
    $testData = [
        '1' => ['id' => 1, 'name' => 'Item 1', 'tenant_id' => $tenantId],
        '2' => ['id' => 2, 'name' => 'Item 2', 'tenant_id' => $tenantId],
    ];

    writeTraitIntegrationJson($this->sushiJsonPath(), $testData);

    $rows = $this->sushiModel()->getSushiRows();

    expect($rows)->toHaveCount(2);
    foreach ($rows as $row) {
        if (! is_array($row)) {
            continue;
        }

        expect($row['tenant_id'] ?? null)->toBe($tenantId);
    }
});

<<<<<<< HEAD
it('handles large datasets efficiently', function (): void {
=======
it('handles complex data structures', function(): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Complex Item',
            'metadata' => [
                'tags' => ['tag1', 'tag2', 'tag3'],
                'settings' => [
                    'enabled' => true,
                    'max_retries' => 3,
                    'timeout' => 30,
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

    // Crea il file JSON di test
    $directory = dirname($this->testJsonPath);
    File::makeDirectory($directory, 0755, true, true);
    File::put($this->testJsonPath, json_encode($testData, JSON_PRETTY_PRINT));

    $rows = $this->model->getSushiRows();

    expect($rows)->toHaveKey('1');
    expect($rows['1']['name'])->toBe('Complex Item');

    // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
    expect($rows['1']['metadata'])->toBeString();

    $decodedMetadata = json_decode($rows['1']['metadata'], true);
    expect($decodedMetadata)->toBe($testData['1']['metadata']);
    expect($decodedMetadata['tags'])->toBe(['tag1', 'tag2', 'tag3']);
    expect($decodedMetadata['nested']['level1']['level2']['level3'])->toBe('deep_value');
});

it('manages file permissions correctly', function(): void {
    $testData = ['1' => ['id' => 1, 'name' => 'Permission Test']];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Verifica che la directory abbia i permessi corretti
    $directory = dirname($this->testJsonPath);
    expect(File::exists($directory))->toBeTrue();

    // Verifica che il file abbia i permessi corretti
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Verifica che il file sia leggibile
    $content = File::get($this->testJsonPath);
    expect($content)->toBeString();
    expect($content)->not->toBeEmpty();
});

it('handles concurrent access safely', function(): void {
    // Simula accesso concorrente creando più istanze del modello
    $model1 = new TestSushiModel;
    $model2 = new TestSushiModel;
    $model3 = new TestSushiModel;

    $testData1 = ['1' => ['id' => 1, 'name' => 'Concurrent Item 1']];
    $testData2 = ['2' => ['id' => 2, 'name' => 'Concurrent Item 2']];
    $testData3 = ['3' => ['id' => 3, 'name' => 'Concurrent Item 3']];

    // Salva i dati in sequenza
    $result1 = $model1->saveToJson($testData1);
    $result2 = $model2->saveToJson($testData2);
    $result3 = $model3->saveToJson($testData3);

    expect($result1)->toBeTrue();
    expect($result2)->toBeTrue();
    expect($result3)->toBeTrue();

    // Verifica che tutti i dati siano stati salvati correttamente
    $finalContent = File::get($this->testJsonPath);
    $finalData = json_decode($finalContent, true);

    expect($finalData)->toHaveKey('1');
    expect($finalData)->toHaveKey('2');
    expect($finalData)->toHaveKey('3');
    expect($finalData['1']['name'])->toBe('Concurrent Item 1');
    expect($finalData['2']['name'])->toBe('Concurrent Item 2');
    expect($finalData['3']['name'])->toBe('Concurrent Item 3');
});

it('handles large datasets efficiently', function(): void {
    // Crea un dataset grande per testare le performance
>>>>>>> provtv/dev
    $largeDataset = [];
    for ($i = 1; $i <= 1000; $i++) {
        $largeDataset[$i] = [
            'id' => $i,
            'name' => "Large Item {$i}",
            'status' => $i % 2 === 0 ? 'active' : 'inactive',
        ];
    }

    $startTime = microtime(true);
    expect($this->sushiModel()->saveToJson($largeDataset))->toBeTrue();
    expect(microtime(true) - $startTime)->toBeLessThan(5.0);

    $rows = $this->sushiModel()->getSushiRows();
    expect($rows)->toHaveCount(1000);
<<<<<<< HEAD
});

it('works with different tenant configurations', function (): void {
    $secondTenant = createTenant([
=======
    expect($loadTime)->toBeLessThan(2.0); // Dovrebbe essere caricato in meno di 2 secondi

    // Verifica alcuni elementi specifici
    expect($rows[1]['name'])->toBe('Large Item 1');
    expect($rows[500]['name'])->toBe('Large Item 500');
    expect($rows[1000]['name'])->toBe('Large Item 1000');
});

it('handles unicode and special characters', function(): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => 'Item con caratteri speciali: à, è, ì, ò, ù',
            'description' => 'Descrizione con emoji 🚀 e simboli €$£¥',
            'metadata' => [
                'special_chars' => 'Caratteri: <>&"\'',
                'unicode' => 'Unicode: 你好世界 🌍',
                'numbers' => '1234567890',
            ],
        ],
    ];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Verifica che il file sia stato creato
    expect(File::exists($this->testJsonPath))->toBeTrue();

    // Carica i dati e verifica che i caratteri speciali siano preservati
    $rows = $this->model->getSushiRows();

    expect($rows)->toHaveKey('1');
    expect($rows['1']['name'])->toBe('Item con caratteri speciali: à, è, ì, ò, ù');
    expect($rows['1']['description'])->toBe('Descrizione con emoji 🚀 e simboli €$£¥');

    // Verifica i metadati
    $metadata = json_decode($rows['1']['metadata'], true);
    expect($metadata['special_chars'])->toBe('Caratteri: <>&"\'');
    expect($metadata['unicode'])->toBe('Unicode: 你好世界 🌍');
    expect($metadata['numbers'])->toBe('1234567890');
});

it('handles empty and null values', function(): void {
    $testData = [
        '1' => [
            'id' => 1,
            'name' => '',
            'description' => null,
            'metadata' => [],
            'status' => 'active',
        ],
        '2' => [
            'id' => 2,
            'name' => 'Valid Item',
            'description' => 'Valid Description',
            'metadata' => null,
            'status' => '',
        ],
    ];

    $result = $this->model->saveToJson($testData);

    expect($result)->toBeTrue();

    // Carica i dati e verifica che i valori vuoti e null siano gestiti correttamente
    $rows = $this->model->getSushiRows();

    expect($rows)->toHaveKey('1');
    expect($rows)->toHaveKey('2');

    // Verifica il primo elemento
    expect($rows['1']['name'])->toBe('');
    expect($rows['1']['description'])->toBeNull();
    expect($rows['1']['metadata'])->toBe('[]');

    // Verifica il secondo elemento
    expect($rows['2']['name'])->toBe('Valid Item');
    expect($rows['2']['description'])->toBe('Valid Description');
    expect($rows['2']['metadata'])->toBeNull();
    expect($rows['2']['status'])->toBe('');
});

it('works with different tenant configurations', function(): void {
    // Crea un secondo tenant per testare l'isolamento
    $secondTenant = Tenant::factory()->create([
>>>>>>> provtv/dev
        'name' => 'second-tenant',
        'domain' => 'second.example.com',
    ]);

    $this->setCurrentTenant($secondTenant);

    $secondModel = new TestSushiModel();
    $secondJsonPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');

    expect($secondModel->saveToJson([
        '1' => ['id' => 1, 'name' => 'Second Tenant Item', 'tenant_id' => $secondTenant->id],
    ]))->toBeTrue();

    expect($secondJsonPath)->not->toBe($this->sushiJsonPath());
    expect(File::exists($secondJsonPath))->toBeTrue();

    if (File::exists($secondJsonPath)) {
        File::delete($secondJsonPath);
    }

    $directory = dirname($secondJsonPath);
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});
