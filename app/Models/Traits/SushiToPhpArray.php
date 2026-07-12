<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

/** @phpstan-ignore trait.unused */
trait SushiToPhpArray
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $name = Str::of($this->getTable())->replace('_', '-')->toString();

        $rows = TenantService::getConfig($name);

        /** @var array<int, array<string, mixed>> $normalized */
        $normalized = [];

        foreach (array_values($rows) as $item) {
            if (! is_array($item)) {
                continue;
            }

            /** @var array<string, mixed> $item */
            $normalized[] = app(FilterConfigStringKeysAction::class)->execute($item);
        }

        return $normalized;
    }

    protected static function bootSushiToPhpArray(): void
    {
        static::creating(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

            $model->toArray();
        });

        static::updating(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

            $model->toArray();
        });

        static::deleting(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }
        });
    }
}
