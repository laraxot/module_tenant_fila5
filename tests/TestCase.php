<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Closure;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;
use Mockery\Expectation;
use Mockery\MockInterface;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Models\Tenant;
use Modules\Tenant\Models\TestSushiModel;
use Modules\Tenant\Providers\TenantServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\XotBaseTestCase;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;
use function Safe\putenv;

/**
 * @property TestSushiModel|null $model
 * @property BaseModel|null $baseModel
 * @property string $testJsonPath
 * @property string $testDirectory
 * @property Closure(int): array<int, array<string, mixed>>|null $createTestData
 */
abstract class TestCase extends XotBaseTestCase
{
    use DatabaseTransactions;

    /** @var TestSushiModel */
    public mixed $model;

    /** @var BaseModel|null */
    public mixed $baseModel = null;

    public ?Tenant $tenant = null;

    public ?Tenant $secondTenant = null;

    public string $testJsonPath = '';

    public string $testDirectory = '';

    /**
     * Fabbrica di dati di prova, iniettata dai test.
     *
     * Il parametro ha un valore di default perche' i due chiamanti la invocano in modo
     * diverso: `sushiTestData()` senza argomenti, il test delle prestazioni con la
     * dimensione del dataset. Il tipo di valore e' `array<int, …>` e non `array-key`
     * perche' e' cio' che accetta `TestSushiModel::saveToJson()`.
     *
     * @var Closure(int): array<int, array<string, mixed>>
     */
    public Closure $createTestData;

    protected function setUp(): void
    {
        parent::setUp();

        $this->model = new TestSushiModel;
        $this->createTestData = static fn (int $count = 0): array => [];
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

    /**
     * Righe di prova per i test Sushi.
     *
     * Il numero e' esplicito e non un default della closure: quante righe servono e' una
     * decisione del chiamante, e nasconderla dentro la closure rendeva impossibile
     * dichiararne il tipo — `Closure(int=)` diceva «parametro opzionale» mentre la closure
     * assegnata lo richiedeva.
     *
     * @return array<int, array<string, mixed>>
     */
    public function sushiTestData(int $count = 10): array
    {
        return ($this->createTestData)($count);
    }

    public function tenantMockExpectation(MockInterface $mock, string $method): Expectation
    {
        $expectation = $mock->shouldReceive($method);
        Assert::assertInstanceOf(Expectation::class, $expectation);

        return $expectation;
    }

    /**
     * @param  array<array-key, mixed>  $rows
     * @return array<string, mixed>
     */
    public function sushiRowById(array $rows, int|string $key): array
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
        return $this->sushiRowById($rows, $key);
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
     * Imposta (o azzera) l'host che `GetTenantNameAction` legge per risolvere il tenant.
     *
     * L'action usa `getenv('SERVER_NAME')` e non la facade `Request`, perche' gira
     * durante `LoadConfiguration`, quando le facade non esistono ancora: scrivere solo
     * `$_SERVER['SERVER_NAME']` non avrebbe alcun effetto. `$_SERVER` resta allineato
     * per il codice che invece legge da li'.
     *
     * @param  string|null  $serverName  L'host da simulare, `null` per rimuoverlo
     */
    public static function setServerNameForTenantTest(?string $serverName): void
    {
        if ($serverName === null) {
            putenv('SERVER_NAME');
            unset($_SERVER['SERVER_NAME']);

            return;
        }

        putenv('SERVER_NAME='.$serverName);
        $_SERVER['SERVER_NAME'] = $serverName;
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
