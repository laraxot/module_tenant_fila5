<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Tests\TestCase;
<<<<<<< HEAD
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

=======
use PHPUnit\Framework\Assert;
>>>>>>> 1ad0554 (.)
use function Safe\json_encode;

uses(TestCase::class);

beforeEach(function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    TestCase::$testDirectory = storage_path('tests/sushi-json');
    TestCase::$testJsonPath = TestCase::$testDirectory.'/test_sushi.json';

    if (! File::exists(TestCase::$testDirectory)) {
        File::makeDirectory(TestCase::$testDirectory, 0o755, true, true);
=======
    $this->testDirectory = storage_path('tests/sushi-json');
    $this->testJsonPath = $this->testDirectory.'/test_sushi.json';

    if (! File::exists($this->testDirectory)) {
        File::makeDirectory($this->testDirectory, 0o755, true, true);
>>>>>>> 1ad0554 (.)
    }
});

afterEach(function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    if (File::exists(TestCase::$testJsonPath)) {
        File::delete(TestCase::$testJsonPath);
=======
    if (File::exists($this->testJsonPath)) {
        File::delete($this->testJsonPath);
>>>>>>> 1ad0554 (.)
    }
});

it('uses isolated json path in testing environment', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    $path = $this->sushiModel()->getJsonFile();

    Assert::assertSame(TestCase::$testJsonPath, $path);
});

it('returns empty rows when json file is missing', function (): void {
    /** @var TestCase $this */
=======
    $path = $this->sushiModel()->getJsonFile();

    Assert::assertSame($this->testJsonPath, $path);
});

it('returns empty rows when json file is missing', function (): void {
>>>>>>> 1ad0554 (.)
    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertSame([], $rows);
});

it('loads rows from valid json file', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
=======
>>>>>>> 1ad0554 (.)
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
    File::put(TestCase::$testJsonPath, json_encode($payload, JSON_PRETTY_PRINT));
=======
    File::put($this->testJsonPath, json_encode($payload, JSON_PRETTY_PRINT));
>>>>>>> 1ad0554 (.)

    $rows = $this->sushiModel()->getSushiRows();

    Assert::assertCount(1, $rows);
    Assert::assertSame('Test Item 1', $rows[0]['name'] ?? null);
});

it('throws when json file is not an array', function (): void {
<<<<<<< HEAD
    /** @var TestCase $this */
    File::put(TestCase::$testJsonPath, json_encode('not-an-array'));

    XotBasePest::assertThrows(
=======
    File::put($this->testJsonPath, json_encode('not-an-array'));

    assertTenantThrows(
>>>>>>> 1ad0554 (.)
        fn (): array => $this->sushiModel()->getSushiRows(),
        Exception::class
    );
});
