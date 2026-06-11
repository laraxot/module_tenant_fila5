<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Modules\Tenant\Actions\Config\SaveTenantConfigAction;
use Modules\Tenant\Tests\TestCase;
use Modules\Xot\Actions\Arr\SaveArrayAction;
use PHPUnit\Framework\Assert;

use function Safe\file_put_contents;
use function Safe\unlink;

uses(TestCase::class);

test('saves tenant config by merging with existing data', function (): void {
    /** @var TestCase $this */
    $configPath = sys_get_temp_dir().'/tenant-db-'.uniqid('', true).'.php';
    file_put_contents($configPath, "<?php\nreturn ['connections' => ['mysql' => ['host' => 'localhost']]];\n");

    $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($configPath): void {
        $mock->allows([
            'execute' => static fn (string $name): string => $name === 'database.php' ? $configPath : $configPath,
        ]);
    });

    $savedData = null;
    $savedPath = null;

    $this->mockService(SaveArrayAction::class, function ($mock) use (&$savedData, &$savedPath, $configPath): void {
        $mock->allows([
            'execute' => static function (mixed $data, mixed $filename) use (&$savedData, &$savedPath, $configPath): bool {
                if (! is_array($data) || ! is_string($filename)) {
                    return false;
                }

                $savedData = $data;
                $savedPath = $filename;

                return $filename === $configPath;
            },
        ]);
    });

    $action = app(SaveTenantConfigAction::class);
    $action->execute('database', ['connections' => ['mysql' => ['database' => 'test_db']]]);

    Assert::assertSame($configPath, $savedPath);
    Assert::assertIsArray($savedData);
    $connections = $savedData['connections'] ?? null;
    Assert::assertIsArray($connections);
    $mysql = $connections['mysql'] ?? null;
    Assert::assertIsArray($mysql);
    Assert::assertSame('localhost', $mysql['host'] ?? null);
    Assert::assertSame('test_db', $mysql['database'] ?? null);

    unlink($configPath);
});

test('saves tenant config when file does not exist', function (): void {
    /** @var TestCase $this */
    $configPath = sys_get_temp_dir().'/tenant-app-'.uniqid('', true).'.php';

    $this->mockService(GetTenantFilePathAction::class, function ($mock) use ($configPath): void {
        $mock->allows([
            'execute' => static fn (string $name): string => $name === 'app.php' ? $configPath : $configPath,
        ]);
    });

    $savedData = null;
    $savedPath = null;

    $this->mockService(SaveArrayAction::class, function ($mock) use (&$savedData, &$savedPath, $configPath): void {
        $mock->allows([
            'execute' => static function (mixed $data, mixed $filename) use (&$savedData, &$savedPath, $configPath): bool {
                if (! is_array($data) || ! is_string($filename)) {
                    return false;
                }

                $savedData = $data;
                $savedPath = $filename;

                return $filename === $configPath;
            },
        ]);
    });

    $action = app(SaveTenantConfigAction::class);
    $action->execute('app', ['name' => 'Test App']);

    Assert::assertSame($configPath, $savedPath);
    Assert::assertSame(['name' => 'Test App'], $savedData);

    if (is_file($configPath)) {
        unlink($configPath);
    }
});
