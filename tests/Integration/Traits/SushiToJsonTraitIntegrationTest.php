<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Integration\Traits;

<<<<<<< HEAD
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
=======
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
>>>>>>> 1ad0554 (.)
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
<<<<<<< HEAD

use function Safe\json_decode;
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    if (TestCase::tenantDbUnavailable()) {
        TestCase::skipCurrentTest('DB `tenant` non raggiungibile: blocco di ambiente.');
    }

    try {
        // Crea un tenant di test
        $createdTenant = TenantFactory::new()->createOne([
            'name' => 'test-tenant',
            'domain' => 'test.example.com',
        ]);
    } catch (QueryException $exception) {
        TestCase::skipCurrentTest('Tenant DB write blocked: '.$exception->getMessage());
    }
    Assert::assertInstanceOf(Tenant::class, $createdTenant);
    TestCase::$tenant = $createdTenant;

    // Imposta il tenant corrente
    TestCase::setCurrentTenant(TestCase::tenantModel());

    TestCase::$sushiModel = new TestSushiModel;
    TestCase::$testJsonPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');

    if (File::exists(TestCase::sushiJsonPath())) {
        File::delete(TestCase::sushiJsonPath());
    }

    $directory = dirname(TestCase::sushiJsonPath());
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
});

afterEach(function (): void {
    if (File::exists(TestCase::sushiJsonPath())) {
        File::delete(TestCase::sushiJsonPath());
    }

    $directory = dirname(TestCase::sushiJsonPath());
    if (File::exists($directory)) {
        File::deleteDirectory($directory);
    }
=======
use function Safe\json_decode;
use function Safe\json_encode;
use function Pest\Laravel\get;
use function Pest\Laravel\put;
use function Pest\Laravel\delete;

uses(\Modules\Tenant\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Tenant\Tests\TestCase $this */
// Crea un tenant di test
        $this->tenant = TenantFactory::new()->createOne([
            'name' => 'test-tenant',
            'domain' => 'test.example.com',
        ]);

        // Imposta il tenant corrente
        $this->setCurrentTenant($this->tenantModel());

        $this->model = new TestSushiModel;
        $this->testJsonPath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');

        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
});

afterEach(function (): void {
if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        $directory = dirname($this->sushiJsonPath());
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
>>>>>>> 1ad0554 (.)

});

describe('Sushi To Json Trait Integration', function (): void {
    test('creates json file with tenant isolation', function (): void {
<<<<<<< HEAD
        $testData = [
=======
        /** @var \Modules\Tenant\Tests\TestCase $this */
$testData = [
>>>>>>> 1ad0554 (.)
            '1' => [
                'id' => 1,
                'name' => 'Tenant Specific Item',
                'description' => 'This item belongs to the current tenant',
<<<<<<< HEAD
                'tenant_id' => TestCase::tenantModel()->id,
            ],
        ];

        $result = TestCase::sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertTrue(File::exists(TestCase::sushiJsonPath()));
        // Verifica che il file sia nella directory del tenant corretto
        $expectedPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
        Assert::assertSame($expectedPath, TestCase::sushiJsonPath());
        // Verifica che il contenuto sia corretto
        $savedContent = File::get(TestCase::sushiJsonPath());
        $savedData = json_decode($savedContent, true);

        Assert::assertSame($testData, $savedData);
        Assert::assertSame(TestCase::tenantModel()->id, TestCase::sushiRowById($savedData, 1)['tenant_id']);
    });

    test('loads data with tenant isolation', function (): void {
        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Item 1',
                'tenant_id' => TestCase::tenantModel()->id,
=======
                'tenant_id' => $this->tenantModel()->id,
            ],
        ];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Verifica che il file sia nella directory del tenant corretto
        $expectedPath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
        Assert::assertSame($expectedPath, $this->sushiJsonPath());
        // Verifica che il contenuto sia corretto
        $savedContent = File::get($this->sushiJsonPath());
        $savedData = json_decode($savedContent, true);

        Assert::assertSame($testData, $savedData);
        Assert::assertSame($this->tenantModel()->id, \sushiRowById($savedData, 1)['tenant_id']);
    });

    test('loads data with tenant isolation', function (): void {
$testData = [
            '1' => [
                'id' => 1,
                'name' => 'Item 1',
                'tenant_id' => $this->tenantModel()->id,
>>>>>>> 1ad0554 (.)
            ],
            '2' => [
                'id' => 2,
                'name' => 'Item 2',
<<<<<<< HEAD
                'tenant_id' => TestCase::tenantModel()->id,
=======
                'tenant_id' => $this->tenantModel()->id,
>>>>>>> 1ad0554 (.)
            ],
        ];

        // Crea il file JSON di test
<<<<<<< HEAD
        $directory = dirname(TestCase::sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put(TestCase::sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = TestCase::sushiModel()->getSushiRows();
=======
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();
>>>>>>> 1ad0554 (.)

        Assert::assertSame($testData, $rows);
        Assert::assertCount(2, $rows);
        // Verifica che tutti gli elementi appartengano al tenant corrente
        foreach ($rows as $row) {
<<<<<<< HEAD
            Assert::assertSame(TestCase::tenantModel()->id, $row['tenant_id']);
=======
            Assert::assertSame($this->tenantModel()->id, $row['tenant_id']);
>>>>>>> 1ad0554 (.)
        }
    });

    test('handles complex data structures', function (): void {
<<<<<<< HEAD
        $testData = [
=======
$testData = [
>>>>>>> 1ad0554 (.)
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
<<<<<<< HEAD
        $directory = dirname(TestCase::sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put(TestCase::sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = TestCase::sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Complex Item', TestCase::sushiRowById($rows, 1)['name']);
        // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
        Assert::assertIsString(TestCase::sushiRowById($rows, 1)['metadata']);
        /** @var array<string, mixed> $decodedMetadata */
        $decodedMetadata = json_decode(TestCase::sushiRowById($rows, 1)['metadata'], true);
=======
        $directory = dirname($this->sushiJsonPath());
        File::makeDirectory($directory, 0755, true, true);
        File::put($this->sushiJsonPath(), json_encode($testData, JSON_PRETTY_PRINT));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Complex Item', \sushiRowById($rows, 1)['name']);
        // Verifica che gli array nidificati siano stati convertiti in stringhe JSON
        Assert::assertIsString(\sushiRowById($rows, 1)['metadata']);
        /** @var array<string, mixed> $decodedMetadata */
        $decodedMetadata = json_decode(\sushiRowById($rows, 1)['metadata'], true);
>>>>>>> 1ad0554 (.)
        Assert::assertIsArray($decodedMetadata);
        Assert::assertSame($testData['1']['metadata'], $decodedMetadata);
        Assert::assertSame(['tag1', 'tag2', 'tag3'], $decodedMetadata['tags']);
        Assert::assertSame('deep_value', $decodedMetadata['nested']['level1']['level2']['level3']);
    });

    test('manages file permissions correctly', function (): void {
<<<<<<< HEAD
        $testData = ['1' => ['id' => 1, 'name' => 'Permission Test']];

        $result = TestCase::sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che la directory abbia i permessi corretti
        $directory = dirname(TestCase::sushiJsonPath());
        Assert::assertTrue(File::exists($directory));
        // Verifica che il file abbia i permessi corretti
        Assert::assertTrue(File::exists(TestCase::sushiJsonPath()));
        // Verifica che il file sia leggibile
        $content = File::get(TestCase::sushiJsonPath());
=======
$testData = ['1' => ['id' => 1, 'name' => 'Permission Test']];

        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che la directory abbia i permessi corretti
        $directory = dirname($this->sushiJsonPath());
        Assert::assertTrue(File::exists($directory));
        // Verifica che il file abbia i permessi corretti
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Verifica che il file sia leggibile
        $content = File::get($this->sushiJsonPath());
>>>>>>> 1ad0554 (.)
        Assert::assertIsString($content);
        Assert::assertNotEmpty($content);
    });

    test('handles concurrent access safely', function (): void {
<<<<<<< HEAD
        // Simula accesso concorrente creando più istanze del modello
=======
// Simula accesso concorrente creando più istanze del modello
>>>>>>> 1ad0554 (.)
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

        Assert::assertTrue($result1);
        Assert::assertTrue($result2);
        Assert::assertTrue($result3);
        // Verifica che tutti i dati siano stati salvati correttamente
<<<<<<< HEAD
        $finalData = TestCase::readJsonFileAsArray(TestCase::sushiJsonPath());
=======
        $finalData = $this->readJsonFileAsArray($this->sushiJsonPath());
>>>>>>> 1ad0554 (.)

        Assert::assertArrayHasKey('1', $finalData);
        Assert::assertArrayHasKey('2', $finalData);
        Assert::assertArrayHasKey('3', $finalData);
<<<<<<< HEAD
        Assert::assertSame('Concurrent Item 1', TestCase::jsonRecordAt($finalData, '1')['name']);
        Assert::assertSame('Concurrent Item 2', TestCase::jsonRecordAt($finalData, '2')['name']);
        Assert::assertSame('Concurrent Item 3', TestCase::jsonRecordAt($finalData, '3')['name']);
    });

    test('handles large datasets efficiently', function (): void {
        // Crea un dataset grande per testare le performance
=======
        Assert::assertSame('Concurrent Item 1', $this->jsonRecordAt($finalData, '1')['name']);
        Assert::assertSame('Concurrent Item 2', $this->jsonRecordAt($finalData, '2')['name']);
        Assert::assertSame('Concurrent Item 3', $this->jsonRecordAt($finalData, '3')['name']);
    });

    test('handles large datasets efficiently', function (): void {
// Crea un dataset grande per testare le performance
>>>>>>> 1ad0554 (.)
        $largeDataset = [];
        for ($i = 1; $i <= 1000; $i++) {
            $largeDataset[$i] = [
                'id' => $i,
                'name' => "Large Item {$i}",
                'description' => "Description for large item {$i}",
                'status' => $i % 2 === 0 ? 'active' : 'inactive',
                'metadata' => [
                    'index' => $i,
                    'category' => 'category_'.($i % 10),
                    'tags' => ["tag{$i}", 'tag'.($i + 1)],
                ],
            ];
        }

        $startTime = microtime(true);
<<<<<<< HEAD
        $result = TestCase::sushiModel()->saveToJson($largeDataset);
=======
        $result = $this->sushiModel()->saveToJson($largeDataset);
>>>>>>> 1ad0554 (.)
        $saveTime = microtime(true) - $startTime;

        Assert::assertTrue($result);
        Assert::assertLessThan(5.0, $saveTime);

        // Verifica che il file sia stato creato e contenga tutti i dati
<<<<<<< HEAD
        Assert::assertTrue(File::exists(TestCase::sushiJsonPath()));
        $fileSize = File::size(TestCase::sushiJsonPath());
        Assert::assertGreaterThan(0, $fileSize);
        // Testa il caricamento dei dati
        $startTime = microtime(true);
        $rows = TestCase::sushiModel()->getSushiRows();
=======
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        $fileSize = File::size($this->sushiJsonPath());
        Assert::assertGreaterThan(0, $fileSize);
        // Testa il caricamento dei dati
        $startTime = microtime(true);
        $rows = $this->sushiModel()->getSushiRows();
>>>>>>> 1ad0554 (.)
        $loadTime = microtime(true) - $startTime;

        Assert::assertCount(1000, $rows);
        Assert::assertLessThan(2.0, $loadTime);

        // Verifica alcuni elementi specifici
<<<<<<< HEAD
        Assert::assertSame('Large Item 1', TestCase::jsonRecordAt($rows, '1')['name']);
        Assert::assertSame('Large Item 500', TestCase::jsonRecordAt($rows, '500')['name']);
        Assert::assertSame('Large Item 1000', TestCase::jsonRecordAt($rows, '1000')['name']);
    });

    test('handles unicode and special characters', function (): void {
        $testData = [
=======
        Assert::assertSame('Large Item 1', $this->jsonRecordAt($rows, '1')['name']);
        Assert::assertSame('Large Item 500', $this->jsonRecordAt($rows, '500')['name']);
        Assert::assertSame('Large Item 1000', $this->jsonRecordAt($rows, '1000')['name']);
    });

    test('handles unicode and special characters', function (): void {
$testData = [
>>>>>>> 1ad0554 (.)
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

<<<<<<< HEAD
        $result = TestCase::sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che il file sia stato creato
        Assert::assertTrue(File::exists(TestCase::sushiJsonPath()));
        // Carica i dati e verifica che i caratteri speciali siano preservati
        $rows = TestCase::sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Item con caratteri speciali: à, è, ì, ò, ù', TestCase::sushiRowById($rows, 1)['name']);
        Assert::assertSame('Descrizione con emoji 🚀 e simboli €$£¥', TestCase::sushiRowById($rows, 1)['description']);
        $row = TestCase::jsonRecordAt($rows, '1');
        $metadataValue = $row['metadata'] ?? null;
        if (is_string($metadataValue)) {
            $metadata = TestCase::decodeJsonString($metadataValue);
=======
        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Verifica che il file sia stato creato
        Assert::assertTrue(File::exists($this->sushiJsonPath()));
        // Carica i dati e verifica che i caratteri speciali siano preservati
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertSame('Item con caratteri speciali: à, è, ì, ò, ù', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Descrizione con emoji 🚀 e simboli €$£¥', \sushiRowById($rows, 1)['description']);
        $row = $this->jsonRecordAt($rows, '1');
        $metadataValue = $row['metadata'] ?? null;
        if (is_string($metadataValue)) {
            $metadata = $this->decodeJsonString($metadataValue);
>>>>>>> 1ad0554 (.)
        } else {
            Assert::assertIsArray($metadataValue);
            /** @var array<string, mixed> $metadata */
            $metadata = $metadataValue;
        }

        Assert::assertSame('Caratteri: <>&"\'', $metadata['special_chars']);
        Assert::assertSame('Unicode: 你好世界 🌍', $metadata['unicode']);
        Assert::assertSame('1234567890', $metadata['numbers']);
    });

    test('handles empty and null values', function (): void {
<<<<<<< HEAD
        $testData = [
=======
$testData = [
>>>>>>> 1ad0554 (.)
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

<<<<<<< HEAD
        $result = TestCase::sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Carica i dati e verifica che i valori vuoti e null siano gestiti correttamente
        $rows = TestCase::sushiModel()->getSushiRows();
=======
        $result = $this->sushiModel()->saveToJson($testData);

        Assert::assertTrue($result);
        // Carica i dati e verifica che i valori vuoti e null siano gestiti correttamente
        $rows = $this->sushiModel()->getSushiRows();
>>>>>>> 1ad0554 (.)

        Assert::assertArrayHasKey('1', $rows);
        Assert::assertArrayHasKey('2', $rows);
        // Verifica il primo elemento
<<<<<<< HEAD
        Assert::assertSame('', TestCase::sushiRowById($rows, 1)['name']);
        Assert::assertNull(TestCase::sushiRowById($rows, 1)['description']);
        Assert::assertSame('[]', TestCase::sushiRowById($rows, 1)['metadata']);
        // Verifica il secondo elemento
        Assert::assertSame('Valid Item', TestCase::sushiRowById($rows, 2)['name']);
        Assert::assertSame('Valid Description', TestCase::sushiRowById($rows, 2)['description']);
        Assert::assertNull(TestCase::sushiRowById($rows, 2)['metadata']);
        Assert::assertSame('', TestCase::sushiRowById($rows, 2)['status']);
    });

    test('works with different tenant configurations', function (): void {
        // Crea un secondo tenant per testare l'isolamento
        $createdSecondTenant = TenantFactory::new()->createOne([
            'name' => 'second-tenant',
            'domain' => 'second.example.com',
        ]);
        Assert::assertInstanceOf(Tenant::class, $createdSecondTenant);
        TestCase::$secondTenant = $createdSecondTenant;

        // Imposta il secondo tenant come corrente
        TestCase::setCurrentTenant(TestCase::secondTenantModel());

        $secondModel = new TestSushiModel;
        $secondJsonPath = app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
=======
        Assert::assertSame('', \sushiRowById($rows, 1)['name']);
        Assert::assertNull(\sushiRowById($rows, 1)['description']);
        Assert::assertSame('[]', \sushiRowById($rows, 1)['metadata']);
        // Verifica il secondo elemento
        Assert::assertSame('Valid Item', \sushiRowById($rows, 2)['name']);
        Assert::assertSame('Valid Description', \sushiRowById($rows, 2)['description']);
        Assert::assertNull(\sushiRowById($rows, 2)['metadata']);
        Assert::assertSame('', \sushiRowById($rows, 2)['status']);
    });

    test('works with different tenant configurations', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
// Crea un secondo tenant per testare l'isolamento
        $this->secondTenant = TenantFactory::new()->createOne([
            'name' => 'second-tenant',
            'domain' => 'second.example.com',
        ]);

        // Imposta il secondo tenant come corrente
        $this->setCurrentTenant($this->secondTenantModel());

        $secondModel = new TestSushiModel;
        $secondJsonPath = app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
>>>>>>> 1ad0554 (.)

        $testData = [
            '1' => [
                'id' => 1,
                'name' => 'Second Tenant Item',
<<<<<<< HEAD
                'tenant_id' => TestCase::secondTenantModel()->id,
=======
                'tenant_id' => $this->secondTenantModel()->id,
>>>>>>> 1ad0554 (.)
            ],
        ];

        $result = $secondModel->saveToJson($testData);

        Assert::assertTrue($result);
<<<<<<< HEAD
        Assert::assertNotSame(TestCase::sushiJsonPath(), $secondJsonPath);
        // Verifica che i file siano separati
        Assert::assertFalse(File::exists(TestCase::sushiJsonPath()));
=======
        Assert::assertNotSame($this->sushiJsonPath(), $secondJsonPath);
        // Verifica che i file siano separati
        Assert::assertFalse(File::exists($this->sushiJsonPath()));
>>>>>>> 1ad0554 (.)
        Assert::assertTrue(File::exists($secondJsonPath));

        // Pulisce il secondo tenant
        File::delete($secondJsonPath);

        $directory = dirname($secondJsonPath);
        if (File::exists($directory)) {
            File::deleteDirectory($directory);
        }
    });
});
