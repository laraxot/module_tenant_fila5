<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit;

use Exception;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Mockery;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Tenant\Actions\Models\ResolveTenantModelClassAction;
use Modules\Tenant\Actions\Modules\GetTenantModulesAction;
use Modules\Tenant\Actions\Translations\TranslateTenantKeyAction;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\Tenant\Services\Config\Resolvers\DatabaseConfigResolver;
use Modules\Tenant\Services\Config\Resolvers\MorphMapConfigResolver;
use Modules\Tenant\Services\Config\Resolvers\StandardConfigResolver;
use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToCsvCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonAuthCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsCoverageModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonsNoSchemaModel;
use Modules\Tenant\Tests\Unit\Fixtures\SushiToJsonThrowingQueryModel;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Nwidart\Modules\Facades\Module;
use PHPUnit\Framework\Assert;
use ReflectionMethod;

use function Safe\putenv;

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
uses(\Modules\Tenant\Tests\TestCase::class);
=======
<<<<<<< .merge_file_gLBVNL
uses(\Modules\Tenant\Tests\TestCase::class);
=======
uses(TestCase::class);
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
uses(\Modules\Tenant\Tests\TestCase::class);
>>>>>>> 1ad0554 (.)

// expectMockery() is declared once in TenantCoverageBoostTest.php (same namespace)
// and reused here across the Pest test run.

afterEach(function (): void {
    Mockery::close();
});

test('GetTenantNameAction hits shortened parts when nested host config exists', function (): void {
    $cfgRoot = base_path('config');
    File::ensureDirectoryExists($cfgRoot.'/com/example');
    TestCase::setServerNameForTenantTest('www.foo.example.com');
    Assert::assertSame('com/example', app(GetTenantNameAction::class)->execute());
    File::deleteDirectory($cfgRoot.'/com');
    TestCase::setServerNameForTenantTest(null);
});

test('TranslateTenantKeyAction returns key when lang file missing', function (): void {
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => sys_get_temp_dir().'/tenant-lang-missing-'.uniqid().'.php']);
    });

    Assert::assertSame('messages.hello', app(TranslateTenantKeyAction::class)->execute('messages.hello'));
});

test('TranslateTenantKeyAction returns resolved string translation', function (): void {
    $dir = sys_get_temp_dir().'/tenant_lang_hit_'.uniqid('', true);
    File::ensureDirectoryExists($dir.'/lang/it');
    File::put($dir.'/lang/it/messages.php', "<?php\nreturn ['ok' => 'Ciao'];\n");

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $dir.'/'.$path,
        );
    });

    app()->setLocale('it');
    Assert::assertSame('Ciao', app(TranslateTenantKeyAction::class)->execute('messages.ok'));
    File::deleteDirectory($dir);
});

test('GetTenantModulesAction wraps invalid json decode errors', function (): void {
    $dir = sys_get_temp_dir().'/tenant_mods_bad_'.uniqid('', true);
    File::ensureDirectoryExists($dir);
    File::put($dir.'/modules_statuses.json', '{not-json');

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($dir): void {
        $mock->allows(['execute' => $dir.'/modules_statuses.json']);
    });

    expect(fn (): array => app(GetTenantModulesAction::class)->execute())
        ->toThrow(Exception::class);

    File::deleteDirectory($dir);
});

test('MorphMapConfigResolver throws on missing module segment and invalid result type', function (): void {
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $resolver = new MorphMapConfigResolver();
=======
<<<<<<< .merge_file_gLBVNL
    $resolver = new MorphMapConfigResolver();
=======
    $resolver = new MorphMapConfigResolver;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $resolver = new MorphMapConfigResolver();
>>>>>>> 1ad0554 (.)

    $request = HttpRequest::create('/admin', 'GET');
    app()->instance('request', $request);
    Request::swap($request);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    expect(fn (): mixed => $resolver->resolve('morph_map'))
=======
<<<<<<< .merge_file_gLBVNL
    expect(fn (): mixed => $resolver->resolve('morph_map'))
=======
    expect(fn (): float|int|string|array|null => $resolver->resolve('morph_map'))
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    expect(fn (): mixed => $resolver->resolve('morph_map'))
>>>>>>> 1ad0554 (.)
        ->toThrow(Exception::class, 'Invalid module name');

    $request2 = HttpRequest::create('/admin/tenant/x', 'GET');
    app()->instance('request', $request2);
    Request::swap($request2);

    TestCase::mockAppService(GetAllModelsByModuleNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => []]);
    });
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => sys_get_temp_dir().'/no-morph-'.uniqid().'.php']);
    });
    config(['morph_map' => ['flag' => true]]);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    expect(fn (): mixed => $resolver->resolve('morph_map.flag'))
=======
<<<<<<< .merge_file_gLBVNL
    expect(fn (): mixed => $resolver->resolve('morph_map.flag'))
=======
    expect(fn (): float|int|string|array|null => $resolver->resolve('morph_map.flag'))
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    expect(fn (): mixed => $resolver->resolve('morph_map.flag'))
>>>>>>> 1ad0554 (.)
        ->toThrow(Exception::class, 'Invalid morph_map configuration type');
});

test('DatabaseConfigResolver covers empty original config and skip branches', function (): void {
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $resolver = new DatabaseConfigResolver();
=======
<<<<<<< .merge_file_gLBVNL
    $resolver = new DatabaseConfigResolver();
=======
    $resolver = new DatabaseConfigResolver;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $resolver = new DatabaseConfigResolver();
>>>>>>> 1ad0554 (.)
    $original = config('database');

    try {
        config(['database' => 'invalid']);
        $result = $resolver->resolve('database', [
            'default' => null,
            'connections' => null,
        ]);
        Assert::assertIsArray($result);

        config(['database' => ['default' => null]]);
        $result2 = $resolver->resolve('database', [
            'default' => null,
            'connections' => ['mysql' => ['driver' => 'mysql']],
        ]);
        Assert::assertIsArray($result2);

        // default null → early return without mutating connections
        $result3 = $resolver->resolve('database', ['connections' => []]);
        Assert::assertIsArray($result3);
    } finally {
        config(['database' => $original]);
    }
});

test('StandardConfigResolver database path when resolver returns non-array', function (): void {
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $resolver = new StandardConfigResolver();
=======
<<<<<<< .merge_file_gLBVNL
    $resolver = new StandardConfigResolver();
=======
    $resolver = new StandardConfigResolver;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $resolver = new StandardConfigResolver();
>>>>>>> 1ad0554 (.)
    TestCase::mockAppService(GetTenantNameAction::class, static function (MockInterface $mock): void {
        $mock->allows(['execute' => 'localhost']);
    });

    // Force DatabaseConfigResolver::resolve to return null via non-array extraConf from tenant
    config([
        'database' => ['default' => config('database.default'), 'connections' => config('database.connections')],
        'localhost.database' => 'not-an-array',
    ]);

    Assert::assertIsArray($resolver->resolve('database'));
});

test('SushiToJson private helpers cover early returns and audit nulls', function (): void {
    $base = sys_get_temp_dir().'/sushi_json_gap_'.uniqid('', true);
    File::ensureDirectoryExists($base.'/database/content');
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $base.'/'.ltrim($path, '/'),
        );
    });

    $maxRows = new ReflectionMethod(SushiToJsonCoverageModel::class, 'maxIdFromRows');
    $maxRows->setAccessible(true);
    Assert::assertSame(5, $maxRows->invoke(null, [1, ['id' => 5], 'x']));

    $maxDb = new ReflectionMethod(SushiToJsonCoverageModel::class, 'maxIdFromDatabase');
    $maxDb->setAccessible(true);
    Assert::assertIsInt($maxDb->invoke(null));

    $apply = new ReflectionMethod(SushiToJsonCoverageModel::class, 'applyAuditFields');
    $apply->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $model = new SushiToJsonCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $model = new SushiToJsonCoverageModel();
=======
    $model = new SushiToJsonCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $model = new SushiToJsonCoverageModel();
>>>>>>> 1ad0554 (.)
    $apply->invoke(null, $model);
    Assert::assertNull($model->getAttribute('created_by'));

    $applyUp = new ReflectionMethod(SushiToJsonCoverageModel::class, 'applyUpdatingAuditField');
    $applyUp->setAccessible(true);
    $applyUp->invoke(null, $model);

    $updating = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonUpdating');
    $updating->setAccessible(true);
    $updating->invoke(null, $model); // id missing → early return
    $model->setAttribute('id', 99);
    $updating->invoke(null, $model); // index null → early return

    $deleting = new ReflectionMethod(SushiToJsonCoverageModel::class, 'handleSingleJsonDeleting');
    $deleting->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $empty = new SushiToJsonCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $empty = new SushiToJsonCoverageModel();
=======
    $empty = new SushiToJsonCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $empty = new SushiToJsonCoverageModel();
>>>>>>> 1ad0554 (.)
    $deleting->invoke(null, $empty);
    $empty->setAttribute('id', 99);
    $deleting->invoke(null, $empty);

    $boot = new ReflectionMethod(SushiToJsonCoverageModel::class, 'bootSushiToJson');
    $boot->setAccessible(true);
    $boot->invoke(null);

    $eventModel = new SushiToJsonCoverageModel(['name' => 'Evt']);
    $fire = new ReflectionMethod($eventModel, 'fireModelEvent');
    $fire->setAccessible(true);
    try {
        $fire->invoke($eventModel, 'creating', false);
        $fire->invoke($eventModel, 'updating', false);
        $fire->invoke($eventModel, 'deleting', false);
    } catch (\Throwable) {
        // sushi/json IO may fail; boot closures still executed until failure
    }

    $normalize = new ReflectionMethod($model, 'normalizeJsonItems');
    $normalize->setAccessible(true);
    Assert::assertSame([], $normalize->invoke($model, [1, 'x']));

    File::deleteDirectory($base);
});

test('SushiToCsv private helpers cover scalar id and header skip', function (): void {
    $base = sys_get_temp_dir().'/sushi_csv_gap_'.uniqid('', true);
    File::ensureDirectoryExists($base);
    $csvPath = $base.'/sushi_csv_coverage.csv';
    File::put($csvPath, "id,name\n1,A\n");

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($csvPath): void {
        $mock->allows(['execute' => $csvPath]);
    });

    $resolveKey = new ReflectionMethod(SushiToCsvCoverageModel::class, 'resolveRowIdKey');
    $resolveKey->setAccessible(true);
    Assert::assertSame(3, $resolveKey->invoke(null, '3'));
    Assert::assertSame('abc', $resolveKey->invoke(null, 'abc'));

    $build = new ReflectionMethod(SushiToCsvCoverageModel::class, 'buildCsvItemFromData');
    $build->setAccessible(true);
    $item = $build->invoke(null, ['id' => 1, 'name' => 'A'], ['id', 'name', 5]);
    Assert::assertIsArray($item);
    Assert::assertArrayHasKey('id', $item);

    $keyRows = new ReflectionMethod(SushiToCsvCoverageModel::class, 'keyRowsById');
    $keyRows->setAccessible(true);
    Assert::assertSame([], $keyRows->invoke(null, [1, 'x']));

    $normalize = new ReflectionMethod(SushiToCsvCoverageModel::class, 'normalizeRowsForCsv');
    $normalize->setAccessible(true);
    $out = $normalize->invoke(null, [1 => ['id' => 1, 'name' => 'A']]);
    Assert::assertIsArray($out);
    Assert::assertCount(1, $out);

    $boot = new ReflectionMethod(SushiToCsvCoverageModel::class, 'bootSushiToCsv');
    $boot->setAccessible(true);
    $boot->invoke(null);

    File::deleteDirectory($base);
});

test('SushiToJsons covers empty schema map and glob false path via reflection', function (): void {
    $boot = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'bootSushiToJsons');
    $boot->setAccessible(true);
    $boot->invoke(null);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $model = new SushiToJsonsCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $model = new SushiToJsonsCoverageModel();
=======
    $model = new SushiToJsonsCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $model = new SushiToJsonsCoverageModel();
>>>>>>> 1ad0554 (.)
    $map = new ReflectionMethod($model, 'mapJsonFileToRow');
    $map->setAccessible(true);

    $tmp = sys_get_temp_dir().'/jsons_gap_'.uniqid('', true).'.json';
    File::put($tmp, 'null');
    Assert::assertNull($map->invoke($model, $tmp));
    File::put($tmp, json_encode(['name' => 'x'], JSON_THROW_ON_ERROR));
    // with schema present returns row
    Assert::assertIsArray($map->invoke($model, $tmp));
    File::delete($tmp);
});

test('GetTenantNameAction covers null parts and default-host miss/hit', function (): void {
    $cfgRoot = base_path('config');

    TestCase::setServerNameForTenantTest('example.com');
    Assert::assertIsString(app(GetTenantNameAction::class)->execute());

    TestCase::setServerNameForTenantTest('a.b.c.example.com');
    Assert::assertIsString(app(GetTenantNameAction::class)->execute());

    putenv('SERVER_NAME');
    $_SERVER['SERVER_NAME'] = 'www.zzz.example.com';
    File::ensureDirectoryExists($cfgRoot.'/com/example');
    Assert::assertSame('com/example', app(GetTenantNameAction::class)->execute());
    File::deleteDirectory($cfgRoot.'/com');

    TestCase::setServerNameForTenantTest(null);
    unset($_SERVER['SERVER_NAME']);
    File::ensureDirectoryExists($cfgRoot.'/test/defaulthost');
    config(['app.url' => 'https://defaulthost.test']);
    Assert::assertSame('test/defaulthost', app(GetTenantNameAction::class)->execute());
    File::deleteDirectory($cfgRoot.'/test');
});

test('Sushi audit fields with named auth model and csv scalar id', function (): void {
    $base = sys_get_temp_dir().'/sushi_audit_'.uniqid('', true);
    File::ensureDirectoryExists($base);
    $csvPath = $base.'/sushi_csv_coverage.csv';
    File::put($csvPath, "id,name,updated_at,updated_by,created_at,created_by\n1,Alpha,,,,\n");
    File::ensureDirectoryExists($base.'/database/content');

    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base, $csvPath): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(static function (string $path) use ($base, $csvPath): string {
            if (str_ends_with($path, '.csv')) {
                return $csvPath;
            }

            return $base.'/'.ltrim($path, '/');
        });
    });

    $apply = new ReflectionMethod(SushiToJsonAuthCoverageModel::class, 'applyAuditFields');
    $apply->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $authModel = new SushiToJsonAuthCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $authModel = new SushiToJsonAuthCoverageModel();
=======
    $authModel = new SushiToJsonAuthCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $authModel = new SushiToJsonAuthCoverageModel();
>>>>>>> 1ad0554 (.)
    $apply->invoke(null, $authModel);
    Assert::assertSame(42, $authModel->getAttribute('created_by'));

    $applyUp = new ReflectionMethod(SushiToJsonAuthCoverageModel::class, 'applyUpdatingAuditField');
    $applyUp->setAccessible(true);
    $applyUp->invoke(null, $authModel);
    Assert::assertSame(42, $authModel->getAttribute('updated_by'));

    $resolveKey = new ReflectionMethod(SushiToCsvCoverageModel::class, 'resolveRowIdKey');
    $resolveKey->setAccessible(true);
    Assert::assertSame('7', $resolveKey->invoke(null, 7.0));

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $invalidSchemaModel = new SushiToJsonsCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $invalidSchemaModel = new SushiToJsonsCoverageModel();
=======
    $invalidSchemaModel = new SushiToJsonsCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $invalidSchemaModel = new SushiToJsonsCoverageModel();
>>>>>>> 1ad0554 (.)
    $schemaProp = new \ReflectionProperty($invalidSchemaModel, 'schema');
    $schemaProp->setAccessible(true);
    $schemaProp->setValue($invalidSchemaModel, 'invalid');
    $resolve = new ReflectionMethod($invalidSchemaModel, 'resolveSchema');
    $resolve->setAccessible(true);
    Assert::assertSame([], $resolve->invoke($invalidSchemaModel));

    $csvBoot = new ReflectionMethod(SushiToCsvCoverageModel::class, 'bootSushiToCsv');
    $csvBoot->setAccessible(true);
    $csvBoot->invoke(null);
    $jsonBoot = new ReflectionMethod(SushiToJsonCoverageModel::class, 'bootSushiToJson');
    $jsonBoot->setAccessible(true);
    $jsonBoot->invoke(null);
    $jsonsBoot = new ReflectionMethod(SushiToJsonsCoverageModel::class, 'bootSushiToJsons');
    $jsonsBoot->setAccessible(true);
    $jsonsBoot->invoke(null);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $csvModel = new SushiToCsvCoverageModel();
    $jsonModel = new SushiToJsonCoverageModel();
    $jsonsModel = new SushiToJsonsCoverageModel();
=======
<<<<<<< .merge_file_gLBVNL
    $csvModel = new SushiToCsvCoverageModel();
    $jsonModel = new SushiToJsonCoverageModel();
    $jsonsModel = new SushiToJsonsCoverageModel();
=======
    $csvModel = new SushiToCsvCoverageModel;
    $jsonModel = new SushiToJsonCoverageModel;
    $jsonsModel = new SushiToJsonsCoverageModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $csvModel = new SushiToCsvCoverageModel();
    $jsonModel = new SushiToJsonCoverageModel();
    $jsonsModel = new SushiToJsonsCoverageModel();
>>>>>>> 1ad0554 (.)
    foreach ([$csvModel, $jsonModel, $jsonsModel] as $model) {
        $fire = new ReflectionMethod($model, 'fireModelEvent');
        $fire->setAccessible(true);
        foreach (['creating', 'updating', 'deleting'] as $event) {
            try {
                $fire->invoke($model, $event, false);
            } catch (\Throwable) {
            }
        }
    }

    File::deleteDirectory($base);
});

test('TenantServiceProvider load user connection and filter model classes', function (): void {
    $provider = new TenantServiceProvider(app());
    $load = new ReflectionMethod($provider, 'loadTenantDatabaseConfig');
    $load->setAccessible(true);
    $default = config('database.default');
    Assert::assertIsString($default);
    $connections = config('database.connections');
    Assert::assertIsArray($connections);
    $connections = app(FilterConfigStringKeysAction::class)->execute($connections);

    app()->instance(ResolveTenantConfigValueAction::class, new class($default, $connections)
    {
        /** @param array<string, mixed> $connections */
        public function __construct(private string $default, private array $connections) {}

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
        public function execute(string $key, mixed $defaultValue = null): mixed
=======
<<<<<<< .merge_file_gLBVNL
        public function execute(string $key, mixed $defaultValue = null): mixed
=======
        /**
         * @param  array<array-key, mixed>|int|string|null  $defaultValue
         * @return array<string, mixed>
         */
        public function execute(string $key, string|int|array|null $defaultValue = null): array
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
        public function execute(string $key, mixed $defaultValue = null): mixed
>>>>>>> 1ad0554 (.)
        {
            return [
                'default' => $this->default,
                'connections' => $this->connections + [
                    'user_'.$this->default => ['driver' => 'sqlite', 'database' => ':memory:'],
                ],
            ];
        }
    });

    /** @var array<string, mixed> $data */
    $data = $load->invoke($provider, $default);
    Assert::assertArrayHasKey('connections', $data);

    $filter = new ReflectionMethod(ResolveTenantModelClassAction::class, 'filterValidModelClasses');
    $filter->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $action = new ResolveTenantModelClassAction();
=======
<<<<<<< .merge_file_gLBVNL
    $action = new ResolveTenantModelClassAction();
=======
    $action = new ResolveTenantModelClassAction;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $action = new ResolveTenantModelClassAction();
>>>>>>> 1ad0554 (.)
    /** @var array<string, class-string> $filtered */
    $filtered = $filter->invoke($action, [
        1 => Tenant::class,
        'tenant' => Tenant::class,
        'bad' => 'Modules\\Nope\\Missing',
    ]);
    Assert::assertArrayHasKey('tenant', $filtered);
    Assert::assertArrayNotHasKey('bad', $filtered);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $db = new DatabaseConfigResolver();
=======
<<<<<<< .merge_file_gLBVNL
    $db = new DatabaseConfigResolver();
=======
    $db = new DatabaseConfigResolver;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $db = new DatabaseConfigResolver();
>>>>>>> 1ad0554 (.)
    $result = $db->resolve('database', [
        'default' => 'missing_conn',
        'connections' => ['sqlite' => ['driver' => 'sqlite']],
    ]);
    Assert::assertIsArray($result);
});

test('final remaining statement branches', function (): void {
    $maxDb = new ReflectionMethod(SushiToJsonThrowingQueryModel::class, 'maxIdFromDatabase');
    $maxDb->setAccessible(true);
    Assert::assertSame(0, $maxDb->invoke(null));

    $resolveDefaultHost = new ReflectionMethod(GetTenantNameAction::class, 'resolveFromDefaultHost');
    $resolveDefaultHost->setAccessible(true);
    $tenantNameAction = app(GetTenantNameAction::class);
    Assert::assertNull($resolveDefaultHost->invoke($tenantNameAction, ''));
    Assert::assertNull($resolveDefaultHost->invoke($tenantNameAction, 'no.such.tenant.config.path.xyz'));

    TestCase::setServerNameForTenantTest('nomatch.invalid');
    config(['app.url' => 'https://also.invalid.test']);
    Assert::assertSame('localhost', app(GetTenantNameAction::class)->execute());
    TestCase::setServerNameForTenantTest(null);

    TestCase::mockAppService(ResolveTenantConfigValueAction::class, static function (MockInterface $mock): void {
        TestCase::expectMockery($mock, 'execute')->andReturn(99);
    });
    expect(fn (): string => app(ResolveTenantModelClassAction::class)->execute('widget'))
        ->toThrow(Exception::class);

<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
=======
<<<<<<< .merge_file_gLBVNL
>>>>>>> .merge_file_apkhXb
=======
>>>>>>> 1ad0554 (.)
    Module::shouldReceive('allEnabled')->andReturn([new \stdClass()]);
    $getAll = new ReflectionMethod(ResolveTenantModelClassAction::class, 'getAllModulesModels');
    $getAll->setAccessible(true);
    Assert::assertSame([], $getAll->invoke(new ResolveTenantModelClassAction()));
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
=======
=======
    Module::shouldReceive('allEnabled')->andReturn([new \stdClass]);
    $getAll = new ReflectionMethod(ResolveTenantModelClassAction::class, 'getAllModulesModels');
    $getAll->setAccessible(true);
    Assert::assertSame([], $getAll->invoke(new ResolveTenantModelClassAction));
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
>>>>>>> 1ad0554 (.)

    $provider = new TenantServiceProvider(app());
    $load = new ReflectionMethod($provider, 'loadTenantDatabaseConfig');
    $load->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    app()->instance(ResolveTenantConfigValueAction::class, new class()
    {
        public function execute(string $key, mixed $defaultValue = null): mixed
=======
<<<<<<< .merge_file_gLBVNL
    app()->instance(ResolveTenantConfigValueAction::class, new class()
    {
        public function execute(string $key, mixed $defaultValue = null): mixed
=======
    app()->instance(ResolveTenantConfigValueAction::class, new class
    {
        /**
         * @param  array<array-key, mixed>|int|string|null  $defaultValue
         * @return array<string, mixed>
         */
        public function execute(string $key, string|int|array|null $defaultValue = null): array
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    app()->instance(ResolveTenantConfigValueAction::class, new class()
    {
        public function execute(string $key, mixed $defaultValue = null): mixed
>>>>>>> 1ad0554 (.)
        {
            return [
                'default' => 'sqlite',
                'connections' => [
                    'sqlite' => ['driver' => 'sqlite'],
                    'user_sqlite' => ['driver' => 'sqlite', 'database' => ':memory:'],
                ],
            ];
        }
    });
    /** @var array<string, mixed> $data */
    $data = $load->invoke($provider, 'sqlite');
    Assert::assertIsArray($data);
    Assert::assertArrayHasKey('connections', $data);
    $loadedConnections = $data['connections'];
    Assert::assertIsArray($loadedConnections);
    Assert::assertArrayHasKey('user', $loadedConnections);

    $merge = new ReflectionMethod($provider, 'mergeModuleConnections');
    $merge->setAccessible(true);
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    Module::shouldReceive('getOrdered')->andReturn([new \stdClass()]);
=======
<<<<<<< .merge_file_gLBVNL
    Module::shouldReceive('getOrdered')->andReturn([new \stdClass()]);
=======
    Module::shouldReceive('getOrdered')->andReturn([new \stdClass]);
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    Module::shouldReceive('getOrdered')->andReturn([new \stdClass()]);
>>>>>>> 1ad0554 (.)
    $merged = $merge->invoke($provider, [
        'connections' => ['sqlite' => ['driver' => 'sqlite']],
    ], 'sqlite');
    Assert::assertIsArray($merged);
    Assert::assertArrayHasKey('sqlite', $merged);

    $base = sys_get_temp_dir().'/jsons_noschema_'.uniqid('', true);
    File::ensureDirectoryExists($base.'/database/content/sushi_jsons_noschema');
    File::put($base.'/database/content/sushi_jsons_noschema/1.json', json_encode(['name' => 'x'], JSON_THROW_ON_ERROR));
    TestCase::mockAppService(GetTenantFilePathAction::class, static function (MockInterface $mock) use ($base): void {
        TestCase::expectMockery($mock, 'execute')->andReturnUsing(
            static fn (string $path): string => $base.'/'.ltrim($path, '/'),
        );
    });
<<<<<<< HEAD
<<<<<<< .merge_file_wtenQP
    $noSchema = new SushiToJsonsNoSchemaModel();
=======
<<<<<<< .merge_file_gLBVNL
    $noSchema = new SushiToJsonsNoSchemaModel();
=======
    $noSchema = new SushiToJsonsNoSchemaModel;
>>>>>>> .merge_file_Fy8yOO
>>>>>>> .merge_file_apkhXb
=======
    $noSchema = new SushiToJsonsNoSchemaModel();
>>>>>>> 1ad0554 (.)
    Assert::assertSame([], $noSchema->getSushiRows());
    File::deleteDirectory($base);
});
