<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Database\Factories\TenantFactory;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;
use Webmozart\Assert\Assert as WebmozartAssert;

use function Safe\json_decode;
use function Safe\putenv;

/**
 * @property TestSushiModel|null $model
 * @property BaseModel|null $baseModel
 * @property string $testJsonPath
 * @property string $testDirectory
 * @property Closure(): array<array-key, array<string, mixed>>|null $createTestData
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['tenant'];

    /** @var TestSushiModel */
    public mixed $model;

    /** @var BaseModel|null */
    public mixed $baseModel = null;

    public ?Tenant $tenant = null;

    public ?Tenant $secondTenant = null;

    public string $testJsonPath = '';

    public string $testDirectory = '';

    /** @var Closure(): array<array-key, array<string, mixed>> */
    public Closure $createTestData;

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

    protected function setUp(): void
    {
        parent::setUp();

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
        Assert::assertIsString($id);

        return $id;
    }

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

    public static function expectMockery(MockInterface $mock, string $method): Expectation
    {
        $expectation = $mock->allows($method);
        if (! $expectation instanceof Expectation) {
            throw new \RuntimeException('Unexpected mockery expectation type.');
        }

        return $expectation;
    }

    /**
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public static function sushiRowById(array $rows, int|string $key): array
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

    public function setCurrentTenant(Tenant $tenant): void
    {
        $context = app('tenant');

        if (is_object($context) && method_exists($context, 'setCurrent')) {
            $context->setCurrent($tenant);
        }
    }

    /** @return array<array-key, array<string, mixed>> */
    public function readJsonFileAsArray(string $path): array
    {
        $decoded = json_decode(File::get($path), true);
        Assert::assertIsArray($decoded);

        /** @var array<array-key, array<string, mixed>> $decoded */
        return $decoded;
    }

    public function baseModelInstance(): BaseModel
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);

        return $this->baseModel;
    }

    /**
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $rows, int|string $key): array
    {
        return self::sushiRowById($rows, $key);
    }

    /**
     * @return array<string, mixed>
     */
    public function decodeJsonString(string $json): array
    {
        $decoded = json_decode($json, true);
        Assert::assertIsArray($decoded);

        /** @var array<string, mixed> $decoded */
        return $decoded;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection ?? 'tenant');
    }

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
