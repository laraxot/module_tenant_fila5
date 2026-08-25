<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
use Sushi\Sushi;

/** @phpstan-ignore trait.unused */
trait SushiToPhpArray
{
    use Sushi;

<<<<<<< HEAD
   /**
=======
    /**
>>>>>>> laraxot/dev
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $name = Str::of($this->getTable())->replace('_', '-')->toString();

<<<<<<< HEAD
       $rows = app(GetTenantConfigArrayAction::class)->execute($name);
=======
        $rows = app(GetTenantConfigArrayAction::class)->execute($name);
>>>>>>> laraxot/dev

        /** @var array<int, array<string, mixed>> $normalized */
        $normalized = [];

        foreach (array_values($rows) as $item) {
            if (! is_array($item)) {
                continue;
            }

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

<<<<<<< HEAD
           $model->toArray();
=======
            $model->toArray();
>>>>>>> laraxot/dev
        });

        static::updating(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

<<<<<<< HEAD
           $model->toArray();
=======
            $model->toArray();
>>>>>>> laraxot/dev
        });

        static::deleting(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }
        });
<<<<<<< HEAD
   }
=======
    }
>>>>>>> laraxot/dev
}
