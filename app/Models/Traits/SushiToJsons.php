<?php

<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
declare(strict_types=1);
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_YguSGW
/**
 * @see https://dev.to/hasanmn/automatically-update-createdby-and-updatedby-in-laravel-using-bootable-traits-28g9.
 */

<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
=======
declare(strict_types=1);

>>>>>>> .merge_file_YguSGW
namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use ReflectionObject;
use function Safe\json_encode;
use function Safe\unlink;
<<<<<<< .merge_file_0exzsp
=======
declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
use Illuminate\Support\Facades\File;
use ReflectionObject;
use function Safe\json_encode;
use function Safe\unlink;
use Sushi\Sushi;
use Webmozart\Assert\Assert;
>>>>>>> 1ad0554 (.)
=======
use Sushi\Sushi;
use Webmozart\Assert\Assert;
>>>>>>> .merge_file_YguSGW

trait SushiToJsons
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
        return $this->collectRowsFromJsonFiles($this->getTable());
=======
=======
>>>>>>> .merge_file_YguSGW
        $tbl = $this->getTable();
        if (! is_string($tbl)) {
            return [];
        }

        return $this->collectRowsFromJsonFiles($tbl);
<<<<<<< .merge_file_0exzsp
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_YguSGW
    }

    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
        $id = $this->getKey();

        $stringId = is_string($id) || is_numeric($id) ? (string) $id : 'unknown';
        $stringTbl = is_string($tbl) ? $tbl : 'unknown';

<<<<<<< HEAD
        return app(GetTenantFilePathAction::class)->execute('database/content/'.$stringTbl.'/'.$stringId.'.json');
=======
        return app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/'.$stringTbl.'/'.$stringId.'.json');
>>>>>>> 1ad0554 (.)
    }

    protected static function bootSushiToJsons(): void
    {
<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
        static::creating(static function (Model $model): void {
=======
        static::creating(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::creating(static function ($model): void {
>>>>>>> .merge_file_YguSGW
            Assert::isInstanceOf($model, static::class);
            self::handleJsonCreating($model);
        });

<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
        static::updating(static function (Model $model): void {
=======
        static::updating(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::updating(static function ($model): void {
>>>>>>> .merge_file_YguSGW
            Assert::isInstanceOf($model, static::class);
            self::handleJsonUpdating($model);
        });

<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
        static::deleting(static function (Model $model): void {
=======
        static::deleting(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::deleting(static function ($model): void {
>>>>>>> .merge_file_YguSGW
            Assert::isInstanceOf($model, static::class);
            self::handleJsonDeleting($model);
        });
    }

    /**
     * @return array<string, mixed>
     *
     * @phpstan-return array<string, mixed>
     */
    protected function resolveSchema(): array
    {
        $reflection = new ReflectionObject($this);
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

    /**
     * @return array<int, array<string, mixed>>
     */
    private function collectRowsFromJsonFiles(string $tbl): array
    {
<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
        $files = File::glob(app(GetTenantFilePathAction::class)->execute('database/content/'.$tbl).'/*.json') ?: [];
=======
        $files = File::glob(app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/'.$tbl).'/*.json');
        if ($files === false) {
            return [];
        }
>>>>>>> 1ad0554 (.)
=======
        $files = File::glob(app(GetTenantFilePathAction::class)->execute('database/content/'.$tbl).'/*.json');
        if ($files === false) {
            return [];
        }
>>>>>>> .merge_file_YguSGW

        /** @var array<int, array<string, mixed>> $rows */
        $rows = [];

        foreach ($files as $file) {
            if (! is_string($file)) {
                continue;
            }
<<<<<<< .merge_file_0exzsp
<<<<<<< HEAD
=======

>>>>>>> 1ad0554 (.)
=======

>>>>>>> .merge_file_YguSGW
            $row = $this->mapJsonFileToRow($file);
            if ($row !== null) {
                $rows[] = $row;
            }
        }

        return $rows;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function mapJsonFileToRow(string $file): ?array
    {
        $json = File::json($file);
        if (! is_array($json)) {
            return null;
        }

        $schema = $this->resolveSchema();
        if ($schema === []) {
            return null;
        }

        return $this->buildRowFromSchema($schema, $json);
    }

    /**
     * @param  array<string, mixed>  $schema
<<<<<<< .merge_file_0exzsp
     * @param  array<string, mixed>  $json
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
=======
     * @param  array<mixed, mixed>  $json
     *
>>>>>>> .merge_file_YguSGW
     * @return array<string, mixed>
     */
    private function buildRowFromSchema(array $schema, array $json): array
    {
        /** @var array<string, mixed> $item */
        $item = [];

        foreach (array_keys($schema) as $name) {
            $value = $json[$name] ?? null;
            if (is_array($value)) {
                $value = json_encode($value, JSON_PRETTY_PRINT);
            }
            $item[$name] = $value;
        }

        return $item;
    }

    private static function handleJsonCreating(self $model): void
    {
        self::assignCreatingMetadata($model);
        self::writeCreatingJsonFile($model);
    }

    private static function assignCreatingMetadata(self $model): void
    {
        $maxId = $model->max('id');
        $newId = is_numeric($maxId) ? (int) $maxId + 1 : 1;

        $model->setAttribute('id', $newId);
        $model->setAttribute('updated_at', now());
        $model->setAttribute('updated_by', authId());
        $model->setAttribute('created_at', now());
        $model->setAttribute('created_by', authId());
    }

    private static function writeCreatingJsonFile(self $model): void
    {
        /** @var array<string, mixed> $data */
        $data = $model->toArray();
        $schema = $model->resolveSchema();
        if ($schema === []) {
            throw new Exception('Schema property must be iterable');
        }

        $item = [];
        foreach (array_keys($schema) as $name) {
            $item[$name] = $data[$name] ?? null;
        }

        $file = $model->getJsonFile();
        $dir = \dirname($file);

        if (! File::exists($dir)) {
            File::makeDirectory($dir, 0o755, true, true);
        }

        File::put($file, json_encode($item, JSON_PRETTY_PRINT));
    }

    private static function handleJsonUpdating(self $model): void
    {
        $model->setAttribute('updated_at', now());
        $model->setAttribute('updated_by', authId());

        File::put($model->getJsonFile(), $model->toJson(JSON_PRETTY_PRINT));
    }

    private static function handleJsonDeleting(self $model): void
    {
        unlink($model->getJsonFile());
    }
}
