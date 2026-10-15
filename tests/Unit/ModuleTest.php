<?php
namespace Modules\Tenant\Tests\Unit;

use Modules\Tenant\Tests\TestCase;
use Modules\Tenant\Models\Tenant;

it('has main model class', function () {
    expect(class_exists(Tenant::class))->toBeTrue();
});
