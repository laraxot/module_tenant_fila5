<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
<<<<<<< HEAD
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
=======
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0o755, true, true);
>>>>>>> laraxot/dev
    }
});

afterEach(function (): void {
    /** @var TestCase $this */
<<<<<<< HEAD
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
=======
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
>>>>>>> laraxot/dev
    }
});

it('uses isolated json path in testing environment', function (): void {
    /** @var TestCase $this */
    $path = $this->sushiModel()->getJsonFile();

<<<<<<< HEAD
    Assert::assertSame($this->testJsonPath, $path);
=======
    Assert::assertSame(TestCase::$testJsonPath, $path);
>>>>>>> laraxot/dev
});

it('returns empty rows when json file is missing', function (): void {
    /** @var TestCase $this */
    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertSame([], $rows);
});

it('loads rows from valid json file', function (): void {
    /** @var TestCase $this */
    $payload = [
        '1' => [
            'id' => 1,
            'name' => 'Test Item 1',
            'description' => 'Description 1',
            'status' => 'active',
            'metadata' => ['key1' => 'value1'],
            'created_at' => now()->toISOString(),
            'updated_at' => now()->toISOString(),
        ],
    ];

<<<<<<< HEAD
    File::put($this->testJsonPath, json_encode($payload, JSON_PRETTY_PRINT));
=======
    File::put(TestCase::$testJsonPath, json_encode($payload, JSON_PRETTY_PRINT));
>>>>>>> laraxot/dev

    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertCount(1, $rows);
    Assert::assertSame('Test Item 1', $rows[0]['name'] ?? null);
});

it('throws when json file is not an array', function (): void {
    /** @var TestCase $this */
<<<<<<< HEAD
    File::put($this->testJsonPath, json_encode('not-an-array'));
=======
    File::put(TestCase::$testJsonPath, json_encode('not-an-array'));
>>>>>>> laraxot/dev

    XotBasePest::assertThrows(
        fn (): array => $this->sushiModel()->getSushiRows(),
        Exception::class
    );
});
