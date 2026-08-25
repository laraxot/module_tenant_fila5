<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Actions\Domains;

use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('gets domains array by scanning config directory', function (): void {
    // This test is a bit tricky because recurse() instantiates Filesystem internally
    // and uses config_path().

<<<<<<< HEAD
   $action = new class() extends GetDomainsArrayAction
=======
    $action = new class() extends GetDomainsArrayAction
>>>>>>> laraxot/dev
    {
        public function recurse(string $path): array
        {
            return [
                'tenant1' => [],
                'group1' => [
                    'tenant2' => [],
                ],
            ];
        }
    };

    $result = $action->execute();

<<<<<<< HEAD
   Assert::assertCount(2, $result);
=======
    Assert::assertCount(2, $result);
>>>>>>> laraxot/dev
    Assert::assertContains(['id' => 'tenant1', 'name' => 'tenant1'], $result);
    Assert::assertContains(['id' => 'tenant2.group1', 'name' => 'tenant2.group1'], $result);
});

it('collapses nested directory structure into dot notation', function (): void {
    $action = app(GetDomainsArrayAction::class);
    $data = [
        'a' => [
            'b' => [
                'c' => [],
            ],
            'd' => [],
        ],
        'e' => [],
    ];

    $result = $action->collapse($data);

<<<<<<< HEAD
   Assert::assertCount(3, $result);
=======
    Assert::assertCount(3, $result);
>>>>>>> laraxot/dev
    Assert::assertContains('c.b.a', $result);
    Assert::assertContains('d.a', $result);
    Assert::assertContains('e', $result);
});
