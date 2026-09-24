<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use League\Csv\Reader;
use League\Csv\Writer;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
=======
use Illuminate\Support\Arr;
use League\Csv\Reader;
use League\Csv\Writer;
use RuntimeException;
>>>>>>> 1ad0554 (.)
use Stringable;
use Sushi\Sushi;
use Webmozart\Assert\Assert;

<<<<<<< HEAD
=======
/** @phpstan-ignore trait.unused */
>>>>>>> 1ad0554 (.)
trait SushiToCsv
{
    use Sushi;

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getSushiRows(): array
    {
<<<<<<< HEAD
        $csv = Reader::from($this->getCsvPath(), 'r');
=======
        $csv = Reader::createFromPath($this->getCsvPath(), 'r');
>>>>>>> 1ad0554 (.)
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $rows = iterator_to_array($records);

        $normalized = [];
        foreach (array_values($rows) as $row) {
<<<<<<< HEAD
=======
            if (! is_array($row)) {
                continue;
            }

>>>>>>> 1ad0554 (.)
            $typedRow = [];
            foreach ($row as $key => $value) {
                $typedRow[(string) $key] = $value;
            }

            $normalized[] = $typedRow;
        }

        return $normalized;
    }

    public function getCsvPath(): string
    {
<<<<<<< HEAD
        return app(GetTenantFilePathAction::class)->execute($this->getTable().'.csv');
=======
        $tbl = $this->getTable();
        if (! is_string($tbl)) {
            throw new RuntimeException('Table name must be a string');
        }

        return app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute($tbl.'.csv');
>>>>>>> 1ad0554 (.)
    }

    /**
     * @return list<string>
     */
    public function getCsvHeader(): array
    {
<<<<<<< HEAD
        $reader = Reader::from($this->getCsvPath(), 'r');
=======
        $reader = Reader::createFromPath($this->getCsvPath(), 'r');
>>>>>>> 1ad0554 (.)
        $reader->setHeaderOffset(0);

        return array_values($reader->getHeader());
    }

    protected static function bootSushiToCsv(): void
    {
<<<<<<< HEAD
        static::creating(static function (Model $model): void {
=======
        static::creating(static function ($model): void {
>>>>>>> 1ad0554 (.)
            Assert::isInstanceOf($model, self::class);
            self::handleCsvCreating($model);
        });

<<<<<<< HEAD
        static::updating(static function (Model $model): void {
=======
        static::updating(static function ($model): void {
>>>>>>> 1ad0554 (.)
            Assert::isInstanceOf($model, self::class);
            self::handleCsvUpdating($model);
        });

<<<<<<< HEAD
        static::deleting(static function (Model $model): void {
=======
        static::deleting(static function ($model): void {
>>>>>>> 1ad0554 (.)
            Assert::isInstanceOf($model, self::class);
            self::handleCsvDeleting($model);
        });
    }

<<<<<<< HEAD
=======
    /**
     * @param  self  $model
     */
>>>>>>> 1ad0554 (.)
    private static function handleCsvCreating(self $model): void
    {
        /** @var int $maxId */
        $maxId = $model->max('id') ?? 0;
<<<<<<< HEAD
        $model->setAttribute('id', $maxId + 1);
        $model->setAttribute('updated_at', now());
        $authIdInt = self::resolveAuthIdInt();
        $model->setAttribute('updated_by', $authIdInt);
        $model->setAttribute('created_at', now());
        $model->setAttribute('created_by', $authIdInt);

        $writer = Writer::from($model->getCsvPath(), 'a+');
=======
        $model->id = $maxId + 1;
        $model->updated_at = now();
        $authIdInt = self::resolveAuthIdInt();
        $model->updated_by = $authIdInt;
        $model->created_at = now();
        $model->created_by = $authIdInt;

        $writer = Writer::createFromPath($model->getCsvPath(), 'a+');
>>>>>>> 1ad0554 (.)
        /** @var array<string, mixed> $modelData */
        $modelData = $model->toArray();
        $writer->insertOne(self::buildCsvItemFromData($modelData, $model->getCsvHeader()));
    }

<<<<<<< HEAD
=======
    /**
     * @param  self  $model
     */
>>>>>>> 1ad0554 (.)
    private static function handleCsvUpdating(self $model): void
    {
        $rowsByKey = self::keyRowsById($model->getSushiRows());
        $idKey = self::resolveRowIdKey($model->getKey());
<<<<<<< HEAD
        $model->setAttribute('updated_at', now());
        $model->setAttribute('updated_by', self::resolveAuthIdInt());
=======
        $model->updated_at = now();
        $model->updated_by = self::resolveAuthIdInt();
>>>>>>> 1ad0554 (.)

        Assert::keyExists($rowsByKey, $idKey);
        /** @var array<string, mixed> $existingRow */
        $existingRow = $rowsByKey[$idKey] ?? [];
        /** @var array<string, mixed> $mergedRow */
        $mergedRow = array_merge($existingRow, $model->toArray());
        $rowsByKey[$idKey] = $mergedRow;

        /** @var array<int|string, array<string, mixed>> $typedRowsByKey */
        $typedRowsByKey = $rowsByKey;

        self::writeCsvFromRows($model, $typedRowsByKey, array_keys($mergedRow));
    }

<<<<<<< HEAD
=======
    /**
     * @param  self  $model
     */
>>>>>>> 1ad0554 (.)
    private static function handleCsvDeleting(self $model): void
    {
        $rowsByKey = self::keyRowsById($model->getSushiRows());
        $idKey = self::resolveRowIdKey($model->getKey());
        Assert::keyExists($rowsByKey, $idKey);
        unset($rowsByKey[$idKey]);

        self::writeCsvFromRows($model, $rowsByKey, $model->getCsvHeader());
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
     * @return array<int|string, array<string, mixed>>
     */
    private static function keyRowsById(array $rows): array
    {
        /** @var array<int|string, array<string, mixed>> $rowsByKey */
        $rowsByKey = [];

        foreach (Arr::keyBy($rows, 'id') as $key => $row) {
            if (! is_array($row)) {
                continue;
            }

            /** @var array<string, mixed> $typedRow */
            $typedRow = $row;
            $rowsByKey[$key] = $typedRow;
        }

        return $rowsByKey;
    }

    private static function resolveAuthIdInt(): ?int
    {
        $authId = authId();

        return $authId !== null ? (int) $authId : null;
    }

<<<<<<< HEAD
    /**
     * @param  mixed  $id  Raw model key from Model::getKey() (int|string expected)
     */
=======
>>>>>>> 1ad0554 (.)
    private static function resolveRowIdKey(mixed $id): int|string
    {
        Assert::notNull($id);
        if (is_int($id)) {
            return $id;
        }
        if (is_string($id)) {
            return is_numeric($id) ? (int) $id : $id;
        }
        Assert::scalar($id);

        return (string) $id;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  list<string>  $header
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
     * @return array<string, float|int|string|null>
     */
    private static function buildCsvItemFromData(array $data, array $header): array
    {
        /** @var array<string, float|int|string|null> $item */
        $item = [];
        foreach ($header as $name) {
            if (! is_string($name)) {
                continue;
            }
<<<<<<< HEAD
            $item[$name] = self::csvValue($data[$name] ?? null);
=======
            $value = $data[$name] ?? null;
            if (is_bool($value)) {
                $value = $value ? '1' : '0';
            }
            $item[$name] = is_scalar($value) || $value === null ? $value : (string) $value;
>>>>>>> 1ad0554 (.)
        }

        return $item;
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
     * @param  list<string>  $header
     */
    private static function writeCsvFromRows(self $model, array $rowsByKey, array $header): void
    {
<<<<<<< HEAD
        $writer = Writer::from($model->getCsvPath(), 'w+');
=======
        $writer = Writer::createFromPath($model->getCsvPath(), 'w+');
>>>>>>> 1ad0554 (.)
        $writer->insertOne($header);
        $writer->insertAll(self::normalizeRowsForCsv($rowsByKey));
    }

    /**
     * @param  array<int|string, array<string, mixed>>  $rowsByKey
<<<<<<< HEAD
     * @return list<array<string, float|int|string|null>>
     */
    private static function normalizeRowsForCsv(array $rowsByKey): array
    {
        /** @var list<array<string, float|int|string|null>> $dataArray */
        $dataArray = [];
        foreach ($rowsByKey as $row) {
            /** @var array<string, float|int|string|null> $cleanRow */
            $cleanRow = [];
            foreach ($row as $key => $value) {
                $cleanRow[(string) $key] = self::csvValue($value);
=======
     *
     * @return list<array<string, float|int|string|Stringable|null>>
     */
    private static function normalizeRowsForCsv(array $rowsByKey): array
    {
        /** @var list<array<string, float|int|string|Stringable|null>> $dataArray */
        $dataArray = [];
        foreach ($rowsByKey as $row) {
            /** @var array<string, float|int|string|Stringable|null> $cleanRow */
            $cleanRow = [];
            foreach ($row as $key => $value) {
                if (! is_string($key) && ! is_int($key)) {
                    continue;
                }
                $normalizedValue = is_bool($value) ? ($value ? '1' : '0') : $value;
                $cleanRow[(string) $key] = is_scalar($normalizedValue) || $normalizedValue === null
                    ? $normalizedValue
                    : (string) $normalizedValue;
>>>>>>> 1ad0554 (.)
            }
            $dataArray[] = $cleanRow;
        }

        return $dataArray;
    }
<<<<<<< HEAD

    /**
     * @param  mixed  $value  Arbitrary model attribute (scalar|Stringable|null expected)
     */
    private static function csvValue(mixed $value): float|int|string|null
    {
        if ($value === null) {
            return null;
        }

        if (is_bool($value)) {
            return $value ? '1' : '0';
        }

        if (is_int($value) || is_float($value) || is_string($value)) {
            return $value;
        }

        if ($value instanceof Stringable) {
            return $value->__toString();
        }

        return null;
    }
=======
>>>>>>> 1ad0554 (.)
}
