<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

trait SushiToPhpArray
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $name = Str::of($this->getTable())->replace('_', '-')->toString();

        $rows = TenantService::getConfig($name);

        return array_values($rows);
    }

    protected static function bootSushiToPhpArray(): void
    {
        static::creating(function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

            $model->toArray();
        });

        static::updating(function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

            $model->toArray();
        });

        static::deleting(function ($model): void {
            if (! $model instanceof Model) {
                return;
            }
        });
    }
}
