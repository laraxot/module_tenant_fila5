<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Symfony\Component\Finder\SplFileInfo;

final class GetTenantConfigNamesActionTest extends TestCase
{
    public function test_gets_tenant_config_names(): void
    {
        $action = app(GetTenantConfigNamesAction::class);

        $file1 = mock(SplFileInfo::class);
        $file1->allows([
            'getExtension' => 'php',
            'getFilenameWithoutExtension' => 'database',
        ]);

        $file2 = mock(SplFileInfo::class);
        $file2->allows([
            'getExtension' => 'php',
            'getFilenameWithoutExtension' => 'app',
        ]);

        $file3 = mock(SplFileInfo::class);
        $file3->allows([
            'getExtension' => 'txt',
        ]);

        File::partialMock()->allows([
            'files' => [$file1, $file2, $file3],
        ]);

        $result = $action->execute();

        Assert::assertCount(2, $result);
        Assert::assertSame(['id' => 1, 'name' => 'database'], $result[0]);
        Assert::assertSame(['id' => 2, 'name' => 'app'], $result[1]);
    }
}
