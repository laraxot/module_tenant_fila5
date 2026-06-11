<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Tenant tests', function (): void {
    beforeEach(function (): void {
        /** @var TestCase $this */
        $this->baseModel = new class extends BaseModel
        {
            protected $table = 'test_tenant_table';
        };
    });

    test('base model extends eloquent model', function (): void {
        /** @var TestCase $this */
        Assert::assertInstanceOf(Model::class, $this->baseModel);
    });

    test('base model has correct table name', function (): void {
        /** @var TestCase $this */
        Assert::assertSame('test_tenant_table', $this->baseModel?->getTable());
    });

    test('base model can be instantiated', function (): void {
        /** @var TestCase $this */
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
    });

    test('base model has proper inheritance chain', function (): void {
        /** @var TestCase $this */
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
        Assert::assertInstanceOf(Model::class, $this->baseModel);
    });

    test('base model has timestamps enabled', function (): void {
        /** @var TestCase $this */
        Assert::assertTrue($this->baseModel?->usesTimestamps());
    });
});
