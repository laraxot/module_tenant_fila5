<?php

declare(strict_types=1);

use Modules\Tenant\Actions\Domains\GetDomainsArrayAction;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('gets domains array by scanning config directory', function (): void {
    $action = new class extends GetDomainsArrayAction
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

    Assert::assertCount(2, $result);
    Assert::assertSame(['id' => 'tenant1', 'name' => 'tenant1'], $result[0]);
    Assert::assertSame(['id' => 'tenant2.group1', 'name' => 'tenant2.group1'], $result[1]);
});

test('collapses nested directory structure into dot notation', function (): void {
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

    Assert::assertCount(3, $result);
    Assert::assertContains('c.b.a', $result);
    Assert::assertContains('d.a', $result);
    Assert::assertContains('e', $result);
});
