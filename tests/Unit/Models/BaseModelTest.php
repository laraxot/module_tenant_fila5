<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\BaseModel;
use Modules\Tenant\Tests\TestCase;
use PHPUnit\Framework\Assert;

final class BaseModelTest extends TestCase
{
    public ?BaseModel $baseModel = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->baseModel = new class extends BaseModel
        {
            protected $table = 'test_tenant_table';
        };
    }

    public function test_base_model_extends_eloquent_model(): void
    {
        Assert::assertInstanceOf(Model::class, $this->baseModel);
    }

    public function test_base_model_has_correct_table_name(): void
    {
        Assert::assertNotNull($this->baseModel);
        Assert::assertSame('test_tenant_table', $this->baseModel->getTable());
    }

    public function test_base_model_can_be_instantiated(): void
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
    }

    public function test_base_model_has_proper_inheritance_chain(): void
    {
        Assert::assertInstanceOf(BaseModel::class, $this->baseModel);
        Assert::assertInstanceOf(Model::class, $this->baseModel);
    }

    public function test_base_model_has_timestamps_enabled(): void
    {
        Assert::assertNotNull($this->baseModel);
        Assert::assertTrue($this->baseModel->usesTimestamps());
    }
}
