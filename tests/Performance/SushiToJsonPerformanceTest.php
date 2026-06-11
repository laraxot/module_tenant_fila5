<?php

declare(strict_types=1);

use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class, DatabaseTransactions::class);

/**
 * @return array<int, array<string, mixed>>
 */
function createTestData(int $recordCount): array
{
    $data = [];
    for ($i = 1; $i <= $recordCount; $i++) {
        $data[$i] = [
            'id' => $i,
            'name' => "Test Item {$i}",
            'description' => "This is a detailed description for test item {$i} with additional information to increase the size of the data",
            'status' => 0 === ($i % 2) ? 'active' : 'inactive',
            'category' => 'Category '.(($i % 10) + 1),
            'priority' => ($i % 5) + 1,
            'tags' => ["tag{$i}", "priority{$i}", "category{$i}"],
            'metadata' => [
                'created_by' => 'test_user',
                'department' => 'testing',
                'location' => 'test_environment',
                'notes' => "Additional notes for item {$i} to increase data size",
                'settings' => [
                    'notifications' => true,
                    'auto_save' => false,
                    'backup_frequency' => 'daily',
                ],
            ],
            'timestamps' => [
                'created_at' => now()->subDays($i)->toISOString(),
                'updated_at' => now()->subHours($i)->toISOString(),
            ],
        ];
    }

    return $data;
}

describe('SushiToJson performance', function (): void {
    beforeEach(function () {
        /** @var TestCase $this */

        // Configura il modello di test
        $this->model = new TestSushiModel;

        // Configura percorsi di test
        $this->testDirectory = storage_path('tests/sushi-json-performance');
        $this->testJsonPath = $this->sushiTestDirectory().'/test_sushi.json';

        // Crea directory di test
        if (! File::exists($this->sushiTestDirectory())) {
            File::makeDirectory($this->sushiTestDirectory(), 0755, true, true);
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

    test('handles small datasets efficiently', function (): void {
        /** @var TestCase $this */
        $smallData = createTestData(10);

        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($smallData);
        $saveTime = microtime(true) - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(0.1, $saveTime); // Salvataggio dataset piccolo deve essere molto veloce

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        Assert::assertCount(10, $loadedData);
        Assert::assertLessThan(0.05, $loadTime); // Caricamento dataset piccolo deve essere istantaneo
    });

    test('handles medium datasets efficiently', function (): void {
        /** @var TestCase $this */
        $mediumData = createTestData(100);

        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($mediumData);
        $saveTime = microtime(true) - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(0.5, $saveTime); // Salvataggio dataset medio deve essere veloce

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        Assert::assertCount(100, $loadedData);
        Assert::assertLessThan(0.2, $loadTime); // Caricamento dataset medio deve essere veloce
    });

    test('handles large datasets efficiently', function (): void {
        /** @var TestCase $this */
        $largeData = createTestData(1000);

        $startTime = microtime(true);
        $result = $this->sushiModel()->saveToJson($largeData);
        $saveTime = microtime(true) - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(2.0, $saveTime); // Salvataggio dataset grande deve essere accettabile

        // Testa caricamento
        $startTime = microtime(true);
        $loadedData = $this->sushiModel()->getSushiRows();
        $loadTime = microtime(true) - $startTime;

        Assert::assertCount(1000, $loadedData);
        Assert::assertLessThan(1.0, $loadTime); // Caricamento dataset grande deve essere accettabile
    });

    test('manages memory usage efficiently', function (): void {
        /** @var TestCase $this */
        $initialMemory = memory_get_usage();

        // Crea dataset grande
        $largeData = createTestData(500);

        $memoryAfterDataCreation = memory_get_usage();
        $dataCreationMemory = $memoryAfterDataCreation - $initialMemory;

        // Salva i dati
        $result = $this->sushiModel()->saveToJson($largeData);
        Assert::assertTrue($result);
        $memoryAfterSave = memory_get_usage();
        $saveMemory = $memoryAfterSave - $memoryAfterDataCreation;

        // Carica i dati
        $loadedData = $this->sushiModel()->getSushiRows();
        Assert::assertCount(500, $loadedData);
        $finalMemory = memory_get_usage();
        $loadMemory = $finalMemory - $memoryAfterSave;

        // Verifica che l'utilizzo di memoria sia ragionevole
        Assert::assertLessThan(50 * 1024 * 1024, $dataCreationMemory); // Creazione dati non deve usare troppa memoria (>50MB)
        Assert::assertLessThan(20 * 1024 * 1024, $saveMemory); // Salvataggio non deve usare troppa memoria (>20MB)
        Assert::assertLessThan(30 * 1024 * 1024, $loadMemory); // Caricamento non deve usare troppa memoria (>30MB)

        // Verifica che la memoria sia stata liberata
        Assert::assertLessThan($initialMemory + (100 * 1024 * 1024), $finalMemory);
    });

    test('handles different file sizes efficiently', function (): void {
        /** @var TestCase $this */
        $sizes = [10, 50, 100, 250, 500];

        foreach ($sizes as $size) {
            $testData = createTestData($size);

            $startTime = microtime(true);
            $result = $this->sushiModel()->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            Assert::assertTrue($result);
            // Verifica dimensione file
            $fileSize = File::size($this->sushiJsonPath());
            Assert::assertGreaterThan(0, $fileSize); // File deve avere dimensione maggiore di 0

            // Verifica che il tempo di salvataggio sia proporzionale alla dimensione
            $expectedMaxTime = $size * 0.001; // 1ms per record
            Assert::assertLessThan($expectedMaxTime, $saveTime); // Salvataggio $size record deve essere veloce

            // Testa caricamento
            $startTime = microtime(true);
            $loadedData = $this->sushiModel()->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            Assert::assertCount($size, $loadedData);
            // Verifica che il tempo di caricamento sia proporzionale alla dimensione
            $expectedMaxLoadTime = $size * 0.0005; // 0.5ms per record
            Assert::assertLessThan($expectedMaxLoadTime, $loadTime); // Caricamento $size record deve essere veloce
        }
    });

    test('handles concurrent access efficiently', function (): void {
        /** @var TestCase $this */
        $testData = createTestData(100);

        // Salva dati iniziali
        $result = $this->sushiModel()->saveToJson($testData);
        Assert::assertTrue($result);
        // Simula accesso concorrente
        $concurrentOperations = 10;
        $startTime = microtime(true);

        for ($i = 0; $i < $concurrentOperations; $i++) {
            $loadedData = $this->sushiModel()->getSushiRows();
            Assert::assertCount(100, $loadedData);
        }

        $totalTime = microtime(true) - $startTime;
        $averageTime = $totalTime / $concurrentOperations;

        // Verifica che l'accesso concorrente sia efficiente
        Assert::assertLessThan(0.1, $averageTime); // Accesso concorrente deve essere veloce
        Assert::assertLessThan(1.0, $totalTime); // Tempo totale per operazioni concorrenti deve essere accettabile
    });

    test('parses json efficiently', function (): void {
        /** @var TestCase $this */
        $testData = createTestData(200);

        // Salva dati
        $result = $this->sushiModel()->saveToJson($testData);
        Assert::assertTrue($result);
        // Testa parsing JSON con diverse dimensioni
        $fileContent = File::get($this->sushiJsonPath());
        $fileSize = strlen($fileContent);

        $startTime = microtime(true);
        $parsedData = $this->decodeJsonString($fileContent);
        $parseTime = microtime(true) - $startTime;

        Assert::assertCount(200, $parsedData);
        // Verifica che il parsing sia veloce
        Assert::assertLessThan(0.1, $parseTime); // Parsing JSON deve essere veloce

        // Verifica che il tempo sia proporzionale alla dimensione
        $expectedMaxTime = $fileSize * 0.000001; // 1 microsecondo per byte
        Assert::assertLessThan($expectedMaxTime, $parseTime); // Parsing deve essere proporzionale alla dimensione
    });

    test('normalizes data efficiently', function (): void {
        /** @var TestCase $this */
        $testData = createTestData(150);

        // Salva dati
        $result = $this->sushiModel()->saveToJson($testData);
        Assert::assertTrue($result);
        // Testa normalizzazione
        $startTime = microtime(true);
        $normalizedData = $this->sushiModel()->getSushiRows();
        $normalizeTime = microtime(true) - $startTime;

        Assert::assertCount(150, $normalizedData);
        // Verifica che la normalizzazione sia veloce
        Assert::assertLessThan(0.1, $normalizeTime); // Normalizzazione dati deve essere veloce

        // Verifica che gli array nidificati siano convertiti in stringhe JSON
        foreach ($normalizedData as $record) {
            Assert::assertIsString($record['tags']);
            Assert::assertIsString($record['metadata']);
            Assert::assertIsString($record['timestamps']);
        }
    });

    test('handles errors efficiently', function (): void {
        /** @var TestCase $this */

        // Testa con file JSON malformato
        File::put($this->sushiJsonPath(), 'invalid json content');

        $startTime = microtime(true);

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();

        $errorTime = microtime(true) - $startTime;

        // Verifica che la gestione degli errori sia veloce
        Assert::assertLessThan(0.1, $errorTime); // Gestione errori deve essere veloce
    });

    test('performs file operations efficiently', function (): void {
        /** @var TestCase $this */
        $testData = createTestData(300);

        // Testa operazioni di file
        $startTime = microtime(true);

        // Scrittura
        $writeResult = $this->sushiModel()->saveToJson($testData);
        $writeTime = microtime(true) - $startTime;

        Assert::assertTrue($writeResult);
        Assert::assertLessThan(1.0, $writeTime); // Scrittura file deve essere veloce

        // Lettura
        $startTime = microtime(true);
        $readResult = $this->sushiModel()->getSushiRows();
        $readTime = microtime(true) - $startTime;

        Assert::assertCount(300, $readResult);
        Assert::assertLessThan(0.5, $readTime); // Lettura file deve essere veloce

        // Verifica che le operazioni siano proporzionali
        Assert::assertLessThan($readTime * 3, $writeTime); // Scrittura non deve essere eccessivamente più lenta della lettura
    });

    test('scales efficiently with data size', function (): void {
        /** @var TestCase $this */
        $sizes = [10, 25, 50, 100, 200];
        $results = [];

        foreach ($sizes as $size) {
            $testData = createTestData($size);

            // Misura tempo di salvataggio
            $startTime = microtime(true);
            $result = $this->sushiModel()->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            Assert::assertTrue($result);
            // Misura tempo di caricamento
            $startTime = microtime(true);
            $loadedData = $this->sushiModel()->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            Assert::assertCount($size, $loadedData);
            $results[$size] = [
                'save_time' => $saveTime,
                'load_time' => $loadTime,
                'total_time' => $saveTime + $loadTime,
            ];
        }

        // Verifica scalabilità
        for ($index = 1; $index < count($sizes); $index++) {
            $size = $sizes[$index];
            $previousSize = $sizes[$index - 1];
            $previousResults = $results[$previousSize];
            $currentResults = $results[$size];

            $expectedMaxGrowth = 2.5;

            $saveGrowth = $currentResults['save_time'] / $previousResults['save_time'];
            $loadGrowth = $currentResults['load_time'] / $previousResults['load_time'];

            Assert::assertLessThan($expectedMaxGrowth, $saveGrowth);
            Assert::assertLessThan($expectedMaxGrowth, $loadGrowth);
        }
    });

    test('meets performance benchmarks', function (): void {
        /** @var TestCase $this */
        $benchmarks = [
            'small' => ['size' => 10, 'max_save' => 0.05, 'max_load' => 0.02],
            'medium' => ['size' => 100, 'max_save' => 0.2, 'max_load' => 0.1],
            'large' => ['size' => 500, 'max_save' => 1.0, 'max_load' => 0.5],
            'xlarge' => ['size' => 1000, 'max_save' => 2.0, 'max_load' => 1.0],
        ];

        foreach ($benchmarks as $category => $benchmark) {
            $testData = createTestData($benchmark['size']);

            // Benchmark salvataggio
            $startTime = microtime(true);
            $result = $this->sushiModel()->saveToJson($testData);
            $saveTime = microtime(true) - $startTime;

            Assert::assertTrue($result);
            Assert::assertLessThan($benchmark['max_save'], $saveTime); // Salvataggio $category dataset deve rispettare il benchmark

            // Benchmark caricamento
            $startTime = microtime(true);
            $loadedData = $this->sushiModel()->getSushiRows();
            $loadTime = microtime(true) - $startTime;

            Assert::assertCount($benchmark['size'], $loadedData);
            Assert::assertLessThan($benchmark['max_load'], $loadTime); // Caricamento $category dataset deve rispettare il benchmark
        }
    });

    test('does not create memory leaks', function (): void {
        /** @var TestCase $this */
        $initialMemory = memory_get_usage();

        // Esegui operazioni multiple
        for ($i = 0; $i < 5; $i++) {
            $testData = createTestData(100);

            // Salva
            $result = $this->sushiModel()->saveToJson($testData);
            Assert::assertTrue($result);
            // Carica
            $loadedData = $this->sushiModel()->getSushiRows();
            Assert::assertCount(100, $loadedData);
            // Forza garbage collection
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }
        }

        $finalMemory = memory_get_usage();
        $memoryIncrease = $finalMemory - $initialMemory;

        // Verifica che non ci siano memory leaks significativi
        Assert::assertLessThan(10 * 1024 * 1024, $memoryIncrease); // Non devono esserci memory leaks significativi (>10MB)
    });
});
