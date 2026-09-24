<?php

<<<<<<< .merge_file_dzqxLV
<<<<<<< HEAD
declare(strict_types=1);
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_W9Spk2
/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

<<<<<<< .merge_file_dzqxLV
<<<<<<< HEAD
=======
declare(strict_types=1);

>>>>>>> 1ad0554 (.)
=======
declare(strict_types=1);

>>>>>>> .merge_file_W9Spk2
namespace Modules\Tenant\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
<<<<<<< HEAD
use Modules\Tenant\Actions\Config\GetTenantConfigArrayAction;
=======
>>>>>>> 1ad0554 (.)
use Sushi\Sushi;

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

<<<<<<< HEAD
        $rows = app(GetTenantConfigArrayAction::class)->execute($name);
=======
        $rows = app(\Modules\Tenant\Actions\Config\GetTenantConfigArrayAction::class)->execute($name);
>>>>>>> 1ad0554 (.)

        /** @var array<int, array<string, mixed>> $normalized */
        $normalized = [];

        foreach (array_values($rows) as $item) {
            if (! is_array($item)) {
                continue;
            }

<<<<<<< HEAD
=======
            /** @var array<string, mixed> $item */
>>>>>>> 1ad0554 (.)
            $normalized[] = app(FilterConfigStringKeysAction::class)->execute($item);
        }

        return $normalized;
    }

    protected static function bootSushiToPhpArray(): void
    {
<<<<<<< .merge_file_dzqxLV
<<<<<<< HEAD
        static::creating(static function (Model $model): void {
=======
        static::creating(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

>>>>>>> .merge_file_W9Spk2
            $model->toArray();
        });

        static::updating(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }

            $model->toArray();
        });
<<<<<<< .merge_file_dzqxLV
=======
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
=======
>>>>>>> .merge_file_W9Spk2

        static::deleting(static function ($model): void {
            if (! $model instanceof Model) {
                return;
            }
        });
<<<<<<< .merge_file_dzqxLV
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_W9Spk2
    }
}
