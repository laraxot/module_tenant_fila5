<?php

declare(strict_types=1);

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Services\TenantService;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

class SushiToJsonTraitPestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

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
    }

    protected function tearDown(): void
    {
        // Cleanup file di test
        if (File::exists($this->sushiJsonPath())) {
            File::delete($this->sushiJsonPath());
        }

        if (File::exists($this->sushiTestDirectory())) {
            File::deleteDirectory($this->sushiTestDirectory());
        }

        parent::tearDown();
    }

    /** @test */
    public function testReturnsCorrectJsonFilePath(): void
    {
        $path = $this->sushiModel()->getJsonFile();

        Assert::assertSame($this->sushiJsonPath(), $path);
        Assert::assertStringEndsWith('test_sushi.json', $path);
    }

    /** @test */
    public function testLoadsExistingDataFromJsonFile(): void
    {
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

        Assert::assertCount(2, $rows);
        Assert::assertSame('Test Item 1', \sushiRowById($rows, 1)['name']);
        Assert::assertSame('Test Item 2', \sushiRowById($rows, 2)['name']);
    }

    /** @test */
    public function testReturnsEmptyArrayWhenFileNotExists(): void
    {
        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertEmpty($rows);
    }

    /** @test */
    public function testThrowsExceptionWithMalformedJson(): void
    {
        File::put($this->sushiJsonPath(), 'invalid json content');

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    }

    /** @test */
    public function testThrowsExceptionWithNonArrayData(): void
    {
        File::put($this->sushiJsonPath(), json_encode('not an array'));

        $this->expectAppException(Exception::class);
        $this->sushiModel()->getSushiRows();
    }

    /** @test */
    public function testValidatesJsonFileStructure(): void
    {
        $validData = [
            '1' => [
                'id' => 1,
                'name' => 'Test Item',
                'status' => 'active',
            ],
        ];

        File::put($this->sushiJsonPath(), json_encode($validData));

        $rows = $this->sushiModel()->getSushiRows();

        Assert::assertNotEmpty($rows);
        Assert::assertArrayHasKey('id', \sushiRowById($rows, 1));
        Assert::assertArrayHasKey('name', \sushiRowById($rows, 1));
        Assert::assertArrayHasKey('status', \sushiRowById($rows, 1));
    }

    /** @test */
    public function testHandlesLargeDatasetsEfficiently(): void
    {
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
    }

    /** @test */
    public function testPreservesDataTypesCorrectly(): void
    {
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
    }
}
