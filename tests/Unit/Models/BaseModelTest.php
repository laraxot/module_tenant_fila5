<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Tenant\Tests\TestCase::class);

beforeEach(function (): void {
    /** @var \Modules\Tenant\Tests\TestCase $this */
$this->baseModel = new class extends BaseModel
        {
            protected $table = 'test_tenant_table';
        };
});

describe('Base Model', function (): void {
    test('_base_model_extends_eloquent_model', function (): void {
        /** @var \Modules\Tenant\Tests\TestCase $this */
Assert::assertInstanceOf(Model::class, $this->baseModel);
    });

    test('_base_model_has_correct_table_name', function (): void {
Assert::assertNotNull($this->baseModel);
        Assert::assertSame('test_tenant_table', $this->baseModel->getTable());
    });

    test('_base_model_can_be_instantiated', function (): void {
Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
    });

    test('_base_model_has_proper_inheritance_chain', function (): void {
Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
        Assert::assertInstanceOf(Model::class, $this->baseModel);
    });

    test('_base_model_has_timestamps_enabled', function (): void {
Assert::assertNotNull($this->baseModel);
        Assert::assertTrue($this->baseModel->usesTimestamps());
    });
});
