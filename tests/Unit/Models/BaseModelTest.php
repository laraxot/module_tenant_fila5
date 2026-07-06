<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

beforeEach(function (): void {
    /** @var TestCase $this */
    $this->baseModel = new class() extends BaseModel
    {
        protected $table = 'test_tenant_table';
    };
});

test('base model extends eloquent model', function (): void {
    /** @var TestCase $this */
    Assert::assertInstanceOf(Model::class, $this->baseModelInstance());
});

test('base model has correct table name', function (): void {
    /** @var TestCase $this */
    Assert::assertSame('test_tenant_table', $this->baseModelInstance()->getTable());
});

test('base model can be instantiated', function (): void {
    /** @var TestCase $this */
    Assert::assertInstanceOf(BaseModel::class, $this->baseModelInstance());
});

test('base model has timestamps enabled', function (): void {
    /** @var TestCase $this */
    Assert::assertTrue($this->baseModelInstance()->usesTimestamps());
});
