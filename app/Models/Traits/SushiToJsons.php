<?php

/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Services\TenantService;
use Sushi\Sushi;

use function Safe\json_encode;
use function Safe\unlink;

trait SushiToJsons
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
        $tbl = $this->getTable();
        $path = TenantService::filePath('database/content/'.$tbl);

        $files = File::glob($path.'/*.json');

        /** @var array<int, array<string, mixed>> $rows */
        $rows = [];

        foreach ($files as $id => $file) {
            if (! is_string($file)) {
                continue;
            }

            $json = File::json($file);

            /** @var array<string, mixed> $item */
            $item = [];

            // Ensure schema is an array
            $schema = $this->resolveSchema();

            /** @var array<string, mixed> $schema */
            foreach ($schema as $name => $type) {
                $value = $json[$name] ?? null;
                if (is_array($value)) {
                    $value = json_encode($value, JSON_PRETTY_PRINT);
                }
                $item[$name] = $value;
            }
            $rows[] = $item;
        }

        return $rows;
    }

    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();

        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

        $filename = 'database/content/'.$stringTbl.'/'.$stringId.'.json';

        return TenantService::filePath($filename);
    }

    public function getConnectionName(): ?string
    {
        return parent::getConnectionName();
    }

    /**
     * bootUpdater function.
     */
    protected static function bootSushiToJsons(): void
    {
        /*
         * During a model create Eloquent will also update the updated_at field so
         * need to have the updated_by field here as well.
         */
        static::creating(function ($model): void {
            /** @var static $model */
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }

            // PHPStan Level 10: Type-safe max() call
            $maxId = $model->max('id');
            $newId = is_numeric($maxId) ? (int) $maxId + 1 : 1;

            // PHPStan Level 10: Use setAttribute for type safety
            $model->setAttribute('id', $newId);
            $model->setAttribute('updated_at', now());
            $model->setAttribute('updated_by', authId());
            $model->setAttribute('created_at', now());
            $model->setAttribute('created_by', authId());

            /** @var array<string, mixed> $data */
            $data = $model->toArray();
            $item = [];

            // PHPStan Level 10: Type-safe schema access
            $schema = $model->resolveSchema();
            if ($schema === []) {
                throw new Exception('Schema property must be iterable');
            }
            foreach ($schema as $name => $type) {
                $value = $data[$name] ?? null;
                $item[$name] = $value;
            }

            $content = json_encode($item, JSON_PRETTY_PRINT);

            $file = $model->getJsonFile();
            if (is_string($file)) {
                $dir = \dirname($file);

                if (! File::exists($dir)) {
                    File::makeDirectory($dir, 0o755, true, true);
                }
                File::put($file, $content);
            }
        });
        /*
         * updating.
         */
        static::updating(function ($model): void {
            /** @var static $model */
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }

            $file = $model->getJsonFile();
            if (is_string($file)) {
                // PHPStan Level 10: Use setAttribute for type safety
                $model->setAttribute('updated_at', now());
                $model->setAttribute('updated_by', authId());

                $content = $model->toJson(JSON_PRETTY_PRINT);

                File::put($file, $content);
            }
        });
        // -------------------------------------------------------------------------------------
        /*
         * Deleting a model is slightly different than creating or deleting.
         * For deletes we need to save the model first with the deleted_by field
         */

        static::deleting(function ($model): void {
            /** @var static $model */
            if (! $model instanceof Model) {
                throw new InvalidArgumentException('Model must be an instance of Illuminate\Database\Eloquent\Model');
            }

            $file = $model->getJsonFile();
            if (is_string($file)) {
                unlink($file);
            }
        });

        // ----------------------
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveSchema(): array
    {
        $reflection = new \ReflectionObject($this);
        if (! $reflection->hasProperty('schema')) {
            return [];
        }

        $property = $reflection->getProperty('schema');
        $property->setAccessible(true);
        $schemaValue = $property->getValue($this);

        if (! is_array($schemaValue)) {
            return [];
        }

        /** @var array<string, mixed> $schemaValue */
        return $schemaValue;
    }

    // end function boot
}

// end trait Updater
