<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Fixcity\Models\User as FixcityUser;
use Mockery\MockInterface;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

/**
 * Base test case for Tenant module.
 *
 * Uses MySQL from .env.testing.
 * All module connections are mapped by TenantServiceProvider.
 * Migrations must be run ONCE externally: php artisan migrate --env=testing
 * DatabaseTransactions handles rollback between tests.
 *
 * @property Tenant|null $tenant
 * @property BaseModel|null $baseModel
 * @property TestSushiModel|null $model
 * @property string|null $testJsonPath
 * @property string|null $testDirectory
 * @property \Closure|null $createTestData
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var list<string> */
    protected $connectionsToTransact = ['sqlite', 'tenant', 'user'];

    public ?Tenant $tenant = null;

    public ?BaseModel $baseModel = null;

    public ?TestSushiModel $model = null;

    public ?string $testJsonPath = null;

    public ?string $testDirectory = null;

    /** @var (callable(): array<int|string, array<string, mixed>>)|null */
    public $createTestData = null;

    /**
     * @param  array<string, mixed>  $data
     */
    public function assertDatabaseHasRow(string $table, array $data, ?string $connection = null): void
    {
        $this->assertDatabaseHas($table, $data, $connection);
    }

    /**
     * @template T of object
     *
     * @param  class-string<T>  $abstract
     * @param  (\Closure(MockInterface&T): void)|null  $callback
     * @return MockInterface&T
     */
    public function mockService(string $abstract, ?\Closure $callback = null): MockInterface
    {
        /** @var MockInterface&T $mock */
        $mock = $this->mock($abstract, $callback);

        return $mock;
    }

    /**
     * @return array<int|string, array<string, mixed>>
     */
    public function decodeJsonString(string $json): array
    {
        $decoded = json_decode($json, true);
        Assert::assertIsArray($decoded);

        /** @var array<int|string, array<string, mixed>> $decoded */
        return $decoded;
    }

    /**
     * @return array<int|string, array<string, mixed>>
     */
    public function readJsonFileAsArray(string $path): array
    {
        return $this->decodeJsonString(File::get($path));
    }

    public function sushiModel(): TestSushiModel
    {
        Assert::assertNotNull($this->model);

        return $this->model;
    }

    public function sushiJsonPath(): string
    {
        Assert::assertNotNull($this->testJsonPath);

        return $this->testJsonPath;
    }

    public function sushiTestDirectory(): string
    {
        Assert::assertNotNull($this->testDirectory);

        return $this->testDirectory;
    }

    /**
     * @return array<int|string, array<string, mixed>>
     */
    public function sushiTestData(): array
    {
        Assert::assertNotNull($this->createTestData);

        $data = ($this->createTestData)();
        Assert::assertIsArray($data);

        /** @var array<int|string, array<string, mixed>> $data */
        return $data;
    }

    /**
     * @param  class-string<\Throwable>  $exception
     */
    public function expectAppException(string $exception): void
    {
        $this->expectException($exception);
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $data
     * @return array<string, mixed>
     */
    public function jsonRecordAt(array $data, int|string $key): array
    {
        Assert::assertArrayHasKey($key, $data);
        $row = $data[$key];
        Assert::assertIsArray($row);

        /** @var array<string, mixed> $row */
        return $row;
    }

    public function tenantModel(): Tenant
    {
        Assert::assertNotNull($this->tenant);

        return $this->tenant;
    }

    public function setCurrentTenant(Tenant $tenant): void
    {
        if (! app()->bound('tenant')) {
            app()->instance('tenant', new class implements TenantContextSetter
            {
                public function setCurrent(Tenant $tenant): void {}
            });
        }

        $manager = app('tenant');
        Assert::assertInstanceOf(TenantContextSetter::class, $manager);
        $manager->setCurrent($tenant);
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

        config(['auth.providers.users.model' => FixcityUser::class]);
    }

    /**
     * @param  Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders(mixed $app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            TenantServiceProvider::class,
        ];
    }
}
