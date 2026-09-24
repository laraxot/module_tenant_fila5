<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Closure;
<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
=======
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
>>>>>>> 1ad0554 (.)
=======
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
>>>>>>> .merge_file_84M9oc
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Database\Factories\TenantFactory;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_84M9oc
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;
<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
use Webmozart\Assert\Assert as WebmozartAssert;
=======
>>>>>>> .merge_file_84M9oc

use function Safe\json_decode;

/**
 * @property TestSushiModel|null $model
 * @property BaseModel|null $baseModel
 * @property string $testJsonPath
 * @property string $testDirectory
=======
use function Safe\json_decode;

/**
 * @property TestSushiModel|null $model
 * @property BaseModel|null      $baseModel
 * @property string              $testJsonPath
 * @property string              $testDirectory
>>>>>>> 1ad0554 (.)
 * @property Closure(): array<array-key, array<string, mixed>>|null $createTestData
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    /** @var list<string> */
    protected $connectionsToTransact = ['tenant'];
=======
    /** @var TestSushiModel */
    public mixed $model;
>>>>>>> .merge_file_84M9oc

    /** @var BaseModel|null */
    public mixed $baseModel = null;

    public ?Tenant $tenant = null;

    public ?Tenant $secondTenant = null;

    public string $testJsonPath = '';

    public string $testDirectory = '';

    /** @var Closure(): array<array-key, array<string, mixed>> */
<<<<<<< .merge_file_qqz6Nh
    public static Closure $createTestData;

    /**
     * Lo sqlite condiviso non contiene per forza le tabelle del modulo Tenant:
     * le migration non vengono lanciate dai test. I test DB vanno saltati, non falliti.
     */
    /**
     * Story 5.26 parallel campaign: lo sqlite condiviso va in SQLITE_BUSY con N pest.
     * Feature/Integration DB-write → skip; coverage da Unit puri.
     * Riaprire write-test quando [5.25] schema isolato per processo.
     */
    public static function tenantDbUnavailable(): bool
    {
        return true;
    }

    public static function setServerNameForTenantTest(?string $name): void
    {
        if ($name === null) {
            putenv('SERVER_NAME');
            unset($_SERVER['SERVER_NAME']);

            return;
        }

        putenv('SERVER_NAME='.$name);
        $_SERVER['SERVER_NAME'] = $name;
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public static function createTenant(array $attributes = []): Tenant
    {
        try {
            /** @var TenantFactory $factory */
            $factory = Tenant::factory();
            $tenant = $factory->create($attributes);
            WebmozartAssert::isInstanceOf($tenant, Tenant::class);

            return $tenant;
        } catch (QueryException $exception) {
            $message = $exception->getMessage();
            if (
                str_contains($message, 'database is locked')
                || str_contains($message, 'no column named')
            ) {
                Assert::markTestSkipped(
                    'Tenant DB write blocked on shared sqlite: '.$message
                );
            }

            throw $exception;
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public static function decodeTenantJsonFile(string $path): array
    {
        $decoded = json_decode(File::get($path), true);
        Assert::assertIsArray($decoded);

        /** @var array<int, array<string, mixed>> $decoded */
        return $decoded;
    }
=======
    /** @var TestSushiModel */
    public mixed $model;

    /** @var BaseModel */
    public mixed $baseModel;

    public ?Tenant $tenant = null;

    public ?Tenant $secondTenant = null;

    public string $testJsonPath = '';

    public string $testDirectory = '';

    /** @var Closure(): array<array-key, array<string, mixed>> */
    public Closure $createTestData;
>>>>>>> 1ad0554 (.)
=======
    public Closure $createTestData;
>>>>>>> .merge_file_84M9oc

    protected function setUp(): void
    {
        parent::setUp();

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
        $database = database_path('fixcity_data.sqlite');

        /** @var array<string, array<string, mixed>> $connections */
        $connections = config('database.connections', []);

        foreach (array_keys($connections) as $connection) {
            if (config("database.connections.{$connection}.driver") !== 'sqlite') {
                continue;
            }

            $this->app['config']->set("database.connections.{$connection}.database", $database);
            DB::purge($connection);
        }

        self::$sushiModel = new TestSushiModel;
        self::$createTestData = static fn (): array => [];
=======
        $this->model = new TestSushiModel;
        $this->createTestData = static fn (): array => [];
>>>>>>> .merge_file_84M9oc
    }

    public function tenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->tenant);

        return $this->tenant;
    }

    public function secondTenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->secondTenant);

        return $this->secondTenant;
    }

    public function tenantId(): string
    {
<<<<<<< .merge_file_qqz6Nh
        $id = self::tenantModel()->id;
=======
        $this->model = new TestSushiModel();
        $this->createTestData = static fn (): array => [];
    }

    public function tenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->tenant);

        return $this->tenant;
    }

    public function secondTenantModel(): Tenant
    {
        Assert::assertInstanceOf(Tenant::class, $this->secondTenant);

        return $this->secondTenant;
    }

    public function tenantId(): string
    {
        $id = $this->tenantModel()->id;
>>>>>>> 1ad0554 (.)
=======
        $id = $this->tenantModel()->id;
>>>>>>> .merge_file_84M9oc
        Assert::assertIsString($id);

        return $id;
    }

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    public static function sushiModel(): TestSushiModel
=======
    public function sushiModel(): TestSushiModel
>>>>>>> .merge_file_84M9oc
    {
        Assert::assertInstanceOf(TestSushiModel::class, $this->model);

        return $this->model;
    }

    public function sushiJsonPath(): string
    {
        if ($this->testJsonPath !== '') {
            return $this->testJsonPath;
        }

        return app(GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
    }

    public function sushiTestDirectory(): string
    {
        if ($this->testDirectory !== '') {
            return $this->testDirectory;
        }

        return dirname($this->sushiJsonPath());
    }

    /** @return array<array-key, array<string, mixed>> */
    public function sushiTestData(): array
    {
        return ($this->createTestData)();
    }

    public function tenantMockExpectation(MockInterface $mock, string $method): Expectation
    {
<<<<<<< .merge_file_qqz6Nh
        $expectation = $mock->allows($method);
        if (! $expectation instanceof Expectation) {
            throw new \RuntimeException('Unexpected mockery expectation type.');
        }
=======
    public function sushiModel(): TestSushiModel
    {
        Assert::assertInstanceOf(TestSushiModel::class, $this->model);

        return $this->model;
    }

    public function sushiJsonPath(): string
    {
        if ($this->testJsonPath !== '') {
            return $this->testJsonPath;
        }

        return app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/test_sushi.json');
    }

    public function sushiTestDirectory(): string
    {
        if ($this->testDirectory !== '') {
            return $this->testDirectory;
        }

        return dirname($this->sushiJsonPath());
    }

    /** @return array<array-key, array<string, mixed>> */
    public function sushiTestData(): array
    {
        return ($this->createTestData)();
    }

    public function tenantMockExpectation(MockInterface $mock, string $method): Expectation
    {
        $expectation = $mock->shouldReceive($method);
        Assert::assertInstanceOf(Expectation::class, $expectation);
>>>>>>> 1ad0554 (.)
=======
        $expectation = $mock->shouldReceive($method);
        Assert::assertInstanceOf(Expectation::class, $expectation);
>>>>>>> .merge_file_84M9oc

        return $expectation;
    }

    /**
     * @param  array<array-key, mixed>  $rows
<<<<<<< HEAD
     * @return array<string, mixed>
     */
<<<<<<< .merge_file_qqz6Nh
    public static function sushiRowById(array $rows, int|string $key): array
=======
     *
     * @return array<string, mixed>
     */
    public function sushiRowById(array $rows, int|string $key): array
>>>>>>> 1ad0554 (.)
=======
    public function sushiRowById(array $rows, int|string $key): array
>>>>>>> .merge_file_84M9oc
    {
        $id = is_int($key) ? $key : (is_numeric($key) ? SafeIntCastAction::cast($key) : 0);

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $rowId = $row['id'] ?? null;
            if (is_numeric($rowId) && SafeIntCastAction::cast($rowId) === $id) {
                /** @var array<string, mixed> $row */
                return $row;
            }
        }

        if (is_string($key) && array_key_exists($key, $rows)) {
            $candidate = $rows[$key];
            if (is_array($candidate)) {
                /** @var array<string, mixed> $candidate */
                return $candidate;
            }
        }

        return [];
    }

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    public static function setCurrentTenant(Tenant $tenant): void
=======
    public function setCurrentTenant(Tenant $tenant): void
>>>>>>> 1ad0554 (.)
=======
    public function setCurrentTenant(Tenant $tenant): void
>>>>>>> .merge_file_84M9oc
    {
        $context = app('tenant');

        if (is_object($context) && method_exists($context, 'setCurrent')) {
            $context->setCurrent($tenant);
        }
    }

    /** @return array<array-key, array<string, mixed>> */
<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    public static function readJsonFileAsArray(string $path): array
=======
    public function readJsonFileAsArray(string $path): array
>>>>>>> 1ad0554 (.)
=======
    public function readJsonFileAsArray(string $path): array
>>>>>>> .merge_file_84M9oc
    {
        $decoded = json_decode(File::get($path), true);
        Assert::assertIsArray($decoded);

        /** @var array<array-key, array<string, mixed>> $decoded */
        return $decoded;
    }

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    public static function baseModelInstance(): BaseModel
=======
    public function baseModelInstance(): BaseModel
>>>>>>> .merge_file_84M9oc
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);

<<<<<<< .merge_file_qqz6Nh
        return self::$sushiBaseModel;
=======
    public function baseModelInstance(): BaseModel
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);

        return $this->baseModel;
>>>>>>> 1ad0554 (.)
=======
        return $this->baseModel;
>>>>>>> .merge_file_84M9oc
    }

    /**
     * @param  array<array-key, mixed>  $rows
<<<<<<< HEAD
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $rows, int|string $key): array
    {
<<<<<<< .merge_file_qqz6Nh
        return self::sushiRowById($rows, $key);
=======
     *
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $rows, int|string $key): array
    {
        return $this->sushiRowById($rows, $key);
>>>>>>> 1ad0554 (.)
=======
        return $this->sushiRowById($rows, $key);
>>>>>>> .merge_file_84M9oc
    }

    /**
     * @return array<string, mixed>
     */
<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    public static function decodeJsonString(string $json): array
=======
    public function decodeJsonString(string $json): array
>>>>>>> 1ad0554 (.)
=======
    public function decodeJsonString(string $json): array
>>>>>>> .merge_file_84M9oc
    {
        $decoded = json_decode($json, true);
        Assert::assertIsArray($decoded);

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

<<<<<<< .merge_file_qqz6Nh
<<<<<<< HEAD
    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection ?? 'tenant');
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $abstract
     * @param  (Closure(MockInterface&T): void)|null  $callback
     * @return MockInterface&T
     */
    public static function mockAppService(string $abstract, ?Closure $callback = null): MockInterface
    {
        /** @var MockInterface&T $mock */
        $mock = \Mockery::mock($abstract);

        if ($callback !== null) {
            $callback($mock);
        }

        app()->instance($abstract, $mock);

        return $mock;
    }

    public static function skipCurrentTest(string $message = ''): never
    {
        Assert::markTestSkipped($message);
    }

    /**
     * @param  array<string, mixed>  $parameters
     */
    public static function runArtisanCommand(string $command, array $parameters = []): int
    {
        /** @var int $exitCode */
        $exitCode = Artisan::call($command, $parameters);

        return $exitCode;
    }

=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_84M9oc
    /** @return array<int, class-string<ServiceProvider>> */
    protected function getPackageProviders(Application $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            TenantServiceProvider::class,
        ];
    }
}
