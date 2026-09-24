<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Traits;

use Exception;
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
=======
use Illuminate\Support\Facades\Auth;
>>>>>>> .merge_file_TtozBO
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
=======
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
>>>>>>> 1ad0554 (.)
use Sushi\Sushi;
use Throwable;
use Webmozart\Assert\Assert;

use function Safe\file_get_contents;
use function Safe\json_decode;
use function Safe\json_encode;

/**
 * Trait SushiToJson.
 *
 * Questo trait permette ai modelli di utilizzare il pacchetto Sushi per leggere
 * dati da file JSON con isolamento per tenant. Ogni tenant ha i propri file JSON
 * nella directory config/{tenant_name}/database/content/.
 *
 * @see https://github.com/calebporzio/sushi
 */
trait SushiToJson
{
    use Sushi;

    /**
     * Ottiene il percorso del file JSON per il modello corrente.
     * Il file è specifico per il tenant corrente e la tabella del modello.
     *
     * @return string Percorso completo del file JSON
     */
    public function getJsonFile(): string
    {
        $tbl = $this->getTable();
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
=======
        if (! is_string($tbl)) {
            throw new InvalidArgumentException(__FILE__.':'.__LINE__.' - '.class_basename(self::class).': Table name must be string');
        }
>>>>>>> .merge_file_TtozBO

        return app(GetTenantFilePathAction::class)->execute('database/content/'.$tbl.'.json');
=======
        if (! is_string($tbl)) {
            throw new InvalidArgumentException(__FILE__.':'.__LINE__.' - '.class_basename(self::class).': Table name must be string');
        }

        return app(\Modules\Tenant\Actions\Config\GetTenantFilePathAction::class)->execute('database/content/'.$tbl.'.json');
>>>>>>> 1ad0554 (.)
    }

    /**
     * Metodo richiesto da Sushi per popolare la tabella in-memory.
     * Delegato a getSushiRows() per mantenere separazione semantica.
     *
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }

    /**
     * Ottiene i dati dal file JSON per il modello Sushi.
     * I dati vengono normalizzati per garantire compatibilità con Eloquent.
     *
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
     * @return array<int, array<string, mixed>>
     *
     * @phpstan-return array<int, array<string, mixed>>
=======
     * @return array<int, array<string, mixed>> Array di record per Sushi
     *
     * @throws Exception Se i dati non sono in formato array valido
>>>>>>> 1ad0554 (.)
=======
     * @return array<int, array<string, mixed>> Array di record per Sushi
     *
     * @throws Exception Se i dati non sono in formato array valido
>>>>>>> .merge_file_TtozBO
     */
    public function getSushiRows(): array
    {
        $path = $this->getJsonFile();
        if (! File::exists($path)) {
            return [];
        }

        $data = json_decode(file_get_contents($path), true);
        if (! \is_array($data)) {
            throw new Exception('Data is not array ['.$path.']');
        }

        /** @var array<int, array<string, mixed>> $typedData */
        $typedData = [];
        foreach (array_values($data) as $item) {
            if (! is_array($item)) {
                continue;
            }

<<<<<<< HEAD
=======
            /** @var array<string, mixed> $item */
>>>>>>> 1ad0554 (.)
            $typedData[] = app(FilterConfigStringKeysAction::class)->execute($item);
        }

        $normalizedData = $this->normalizeJsonItems($typedData);
        $schema = $this->getSchema();
        $form = $this->normalizeSchemaFields(is_array($schema) ? $schema : []);

        return $this->completeSchemaFields($normalizedData, $form);
    }

    /**
     * Carica i dati esistenti dal file JSON.
     * Preserva la struttura originale dei dati senza normalizzazione.
     *
     * @return array<int, array<string, mixed>> Dati esistenti
     */
    public function loadExistingData(): array
    {
        $path = $this->getJsonFile();

        if (! File::exists($path)) {
            return [];
        }

        $content = file_get_contents($path);
        $data = json_decode($content, true);

        if (! is_array($data)) {
            return [];
        }

        // Assicura che i dati abbiano la struttura corretta
        $result = [];
        foreach ($data as $item) {
            if (is_array($item)) {
                $safeItem = [];
                foreach ($item as $key => $value) {
                    $safeItem[(string) $key] = $value;
                }

                $result[] = $safeItem;
            }
        }

        return $result;
    }

    /**
     * Salva i dati del modello nel file JSON.
     * Crea la directory se non esiste e salva con formattazione JSON.
     * Utilizza JSON_PRETTY_PRINT e JSON_UNESCAPED_UNICODE per leggibilità.
     *
     * @param  array<int, array<string, mixed>>  $data  Array di record da salvare
     * @return bool True se il salvataggio è riuscito, false in caso di errore
     */
    public function saveToJson(array $data): bool
    {
        try {
            $file = $this->getJsonFile();
            $this->ensureDirectoryExists(dirname($file));
            File::put($file, json_encode($this->normalizeJsonRecords($data), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return true;
        } catch (Exception $e) {
            report($e);

            return false;
        }
    }

    /**
     * Ottiene l'ID successivo disponibile per un nuovo record.
     *
     * @return int ID successivo disponibile
     */
    protected function getNextId(): int
    {
        $existingData = $this->loadExistingData();

        if ($existingData === []) {
            return 1;
        }

        $maxId = 0;

        foreach ($existingData as $row) {
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
=======
=======
>>>>>>> .merge_file_TtozBO
            if (! \is_array($row)) {
                continue;
            }

<<<<<<< .merge_file_k7l3Tm
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_TtozBO
            $rawId = $row['id'] ?? 0;
            $id = \is_numeric($rawId) ? (int) $rawId : 0;
            $maxId = max($maxId, $id);
        }

        return $maxId + 1;
    }

    /**
     * Boot method per il trait SushiToJson.
     * Gestisce gli eventi di creazione, aggiornamento e cancellazione
     * per sincronizzare automaticamente i dati con i file JSON.
     */
    protected static function bootSushiToJson(): void
    {
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        static::creating(static function (Model $model): void {
=======
        static::creating(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::creating(static function ($model): void {
>>>>>>> .merge_file_TtozBO
            Assert::isInstanceOf($model, static::class);
            self::handleSingleJsonCreating($model);
        });

<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        static::updating(static function (Model $model): void {
=======
        static::updating(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::updating(static function ($model): void {
>>>>>>> .merge_file_TtozBO
            Assert::isInstanceOf($model, static::class);
            self::handleSingleJsonUpdating($model);
        });

<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        static::deleting(static function (Model $model): void {
=======
        static::deleting(static function ($model): void {
>>>>>>> 1ad0554 (.)
=======
        static::deleting(static function ($model): void {
>>>>>>> .merge_file_TtozBO
            Assert::isInstanceOf($model, static::class);
            self::handleSingleJsonDeleting($model);
        });
    }

    /**
     * Trova l'indice del record nell'array dato un id.
     *
     * @param  array<int, array<string, mixed>>  $rows
     * @return int|null Indice se trovato, altrimenti null
     */
    protected function findRowIndexById(array $rows, int $id): ?int
    {
        foreach ($rows as $index => $row) {
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
            if (is_array($row) && self::intValue($row['id'] ?? null) === $id) {
                return is_int($index) ? $index : null;
=======
            if (is_array($row) && ((int) ($row['id'] ?? 0)) === $id) {
                return (int) $index;
>>>>>>> 1ad0554 (.)
=======
            if (! is_array($row)) {
                continue;
            }

            $rawId = $row['id'] ?? 0;
            $rowId = is_numeric($rawId) ? (int) $rawId : 0;
            if ($rowId === $id) {
                return (int) $index;
>>>>>>> .merge_file_TtozBO
            }
        }

        return null;
    }

    /**
     * Ottiene l'ID dell'utente autenticato per i campi di audit.
     */
    protected function authId(): int|string|null
    {
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        return authId();
=======
=======
>>>>>>> .merge_file_TtozBO
        if (\function_exists('authId')) {
            return authId();
        }

        if (class_exists('\Illuminate\Support\Facades\Auth')) {
            return Auth::id();
        }

        return null;
<<<<<<< .merge_file_k7l3Tm
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_TtozBO
    }

    /**
     * Assicura che la directory per il file JSON esista.
     */
    protected function ensureDirectoryExists(string $filePath): void
    {
        $directory = dirname($filePath);

        if (! File::exists($directory)) {
            File::makeDirectory($directory, 0o755, true, true);
        }
    }

    /**
     * @param  array<int, array<string, mixed>>  $data
     * @return array<int, array<string, mixed>>
     */
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
    protected function normalizeJsonItems(array $data): array
    {
        /** @var array<int, array<string, mixed>> $normalizedData */
        $normalizedData = [];

        foreach ($data as $item) {
            if (! \is_array($item)) {
                continue;
            }

            /** @var array<string, mixed> $normalizedItem */
            $normalizedItem = [];
            foreach ($item as $key => $value) {
                $stringKey = is_string($key) ? $key : (string) $key;
                if (\is_array($value) || \is_object($value)) {
                    $value = json_encode($value);
                }
                $normalizedItem[$stringKey] = $value;
            }

            $normalizedData[] = app(FilterConfigStringKeysAction::class)->execute($normalizedItem);
        }

        return $normalizedData;
    }

    /**
     * @param  array<string, mixed>  $schema
     * @return array<string, mixed>
     */
    protected function normalizeSchemaFields(array $schema): array
    {
        return app(FilterConfigStringKeysAction::class)->execute($schema);
    }

    /**
     * @param  array<int, array<string, mixed>>  $normalizedData
     * @param  array<string, mixed>  $form
     * @return array<int, array<string, mixed>>
     */
    protected function completeSchemaFields(array $normalizedData, array $form): array
    {
        // Sushi genera un multi-insert: ogni riga deve avere lo stesso set di colonne.
        // Completare col solo schema non basta quando alcune righe hanno chiavi extra,
        // quindi si usa l'unione delle chiavi di schema e di tutte le righe.
        $allKeys = array_keys($form);
        foreach ($normalizedData as $item) {
            $allKeys = array_merge($allKeys, array_keys($item));
        }

        /** @var list<string> $allKeys */
        $allKeys = array_values(array_unique($allKeys));

        /** @var array<int, array<string, mixed>> $completedData */
        $completedData = [];

        foreach ($normalizedData as $item) {
            /** @var array<string, mixed> $row */
            $row = $item;
            foreach ($allKeys as $safeKey) {
                if (! array_key_exists($safeKey, $row)) {
                    $row[$safeKey] = null;
                }
            }

            ksort($row);
            $completedData[] = $row;
        }

        return $completedData;
    }

    /**
     * @param  array<int, array<string, mixed>>  $data
     * @return array<int, array<string, mixed>>
     */
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_TtozBO
    private function normalizeJsonRecords(array $data): array
    {
        $validatedData = [];

        foreach ($data as $item) {
            if (! is_array($item)) {
                continue;
            }

            $validatedItem = [];
            foreach ($item as $key => $value) {
                $validatedItem[is_string($key) ? $key : (string) $key] = $value;
            }
            $validatedData[] = $validatedItem;
        }

        return $validatedData;
    }

    private static function handleSingleJsonCreating(self $model): void
    {
        $file = $model->getJsonFile();
        $existingData = $model->loadExistingData();
        $nextId = self::resolveNextRecordId($existingData);

        $model->setAttribute('id', $nextId);
        $model->setAttribute('updated_at', now());
        $model->setAttribute('created_at', now());
        self::applyAuditFields($model);

        $existingData[] = $model->getAttributes();
        $model->ensureDirectoryExists($file);
        $model->saveToJson($existingData);
    }

    /**
     * @param  array<int, array<string, mixed>>  $existingData
     */
    private static function resolveNextRecordId(array $existingData): int
    {
        return max(self::maxIdFromRows($existingData), self::maxIdFromDatabase()) + 1;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rows
     */
    private static function maxIdFromRows(array $rows): int
    {
        $maxId = 0;

        foreach ($rows as $row) {
            if (! \is_array($row)) {
                continue;
            }

<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
            $maxId = max($maxId, self::intValue($row['id'] ?? null));
=======
            $rawId = $row['id'] ?? 0;
            $id = \is_numeric($rawId) ? (int) $rawId : 0;
            $maxId = max($maxId, $id);
>>>>>>> 1ad0554 (.)
=======
            $rawId = $row['id'] ?? 0;
            $id = \is_numeric($rawId) ? (int) $rawId : 0;
            $maxId = max($maxId, $id);
>>>>>>> .merge_file_TtozBO
        }

        return $maxId;
    }

    private static function maxIdFromDatabase(): int
    {
        try {
            /** @var int|null $dbMax */
            $dbMax = static::query()->max('id');

            return \is_int($dbMax) ? $dbMax : 0;
        } catch (Throwable) {
            return 0;
        }
    }

    private static function applyAuditFields(self $model): void
    {
        $authId = $model->authId();
        if ($authId === null) {
            return;
        }

        $model->setAttribute('updated_by', $authId);
        $model->setAttribute('created_by', $authId);
    }

    private static function handleSingleJsonUpdating(self $model): void
    {
        $model->setAttribute('updated_at', now());
        self::applyUpdatingAuditField($model);

        $existingData = $model->loadExistingData();
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        $id = self::intValue($model->getAttribute('id'));
=======
        $id = (int) ($model->getAttribute('id') ?? 0);
>>>>>>> 1ad0554 (.)
=======
        $rawId = $model->getAttribute('id');
        $id = is_numeric($rawId) ? (int) $rawId : 0;
>>>>>>> .merge_file_TtozBO
        if ($id <= 0) {
            return;
        }

        $index = $model->findRowIndexById($existingData, $id);
        if ($index === null) {
            return;
        }

        /** @var array<string, mixed> $modelArray */
        $modelArray = $model->toArray();
        $existingData[$index] = $modelArray;
        $model->saveToJson($existingData);
    }

    private static function applyUpdatingAuditField(self $model): void
    {
        $authId = $model->authId();
        if ($authId !== null) {
            $model->setAttribute('updated_by', $authId);
        }
    }

    private static function handleSingleJsonDeleting(self $model): void
    {
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
        $id = self::intValue($model->getAttribute('id'));
=======
        $id = (int) ($model->getAttribute('id') ?? 0);
>>>>>>> 1ad0554 (.)
=======
        $rawId = $model->getAttribute('id');
        $id = is_numeric($rawId) ? (int) $rawId : 0;
>>>>>>> .merge_file_TtozBO
        if ($id <= 0) {
            return;
        }

        $existingData = $model->loadExistingData();
        $index = $model->findRowIndexById($existingData, $id);
        if ($index === null) {
            return;
        }

        unset($existingData[$index]);
        $model->saveToJson(array_values($existingData));
    }

    /**
<<<<<<< .merge_file_k7l3Tm
<<<<<<< HEAD
     * @param  mixed  $value  Raw Eloquent attribute (int|string|float expected)
=======
     * @param  array<int, array<string, mixed>>  $data
     * @return array<int, array<string, mixed>>
>>>>>>> .merge_file_TtozBO
     */
    protected function normalizeJsonItems(array $data): array
    {
        /** @var array<int, array<string, mixed>> $normalizedData */
        $normalizedData = [];

        foreach ($data as $item) {
            if (! \is_array($item)) {
                continue;
            }

            /** @var array<string, mixed> $normalizedItem */
            $normalizedItem = [];
            foreach ($item as $key => $value) {
                $stringKey = is_string($key) ? $key : (string) $key;
                if (\is_array($value) || \is_object($value)) {
                    $value = json_encode($value);
                }
                $normalizedItem[$stringKey] = $value;
            }

            $normalizedData[] = app(FilterConfigStringKeysAction::class)->execute($normalizedItem);
        }

        return $normalizedData;
    }

    /**
     * @param  array<mixed, mixed>  $schema
     * @return array<string, mixed>
     */
    protected function normalizeSchemaFields(array $schema): array
    {
        return app(FilterConfigStringKeysAction::class)->execute($schema);
    }

    /**
     * @param  array<int, array<string, mixed>>  $normalizedData
     * @param  array<string, mixed>  $form
     * @return array<int, array<string, mixed>>
     */
    protected function completeSchemaFields(array $normalizedData, array $form): array
    {
        /** @var array<int, array<string, mixed>> $completedData */
        $completedData = [];

        foreach ($normalizedData as $item) {
            foreach (array_keys($form) as $safeKey) {
                if (! array_key_exists($safeKey, $item)) {
                    $item[$safeKey] = null;
                }
            }

            ksort($item);
            $completedData[] = $item;
        }

<<<<<<< .merge_file_k7l3Tm
        return 0;
=======
     * @param  array<int, array<string, mixed>>  $data
     * @return array<int, array<string, mixed>>
     */
    protected function normalizeJsonItems(array $data): array
    {
        /** @var array<int, array<string, mixed>> $normalizedData */
        $normalizedData = [];

        foreach ($data as $item) {
            if (! \is_array($item)) {
                continue;
            }

            /** @var array<string, mixed> $normalizedItem */
            $normalizedItem = [];
            foreach ($item as $key => $value) {
                $stringKey = is_string($key) ? $key : (string) $key;
                if (\is_array($value) || \is_object($value)) {
                    $value = json_encode($value);
                }
                $normalizedItem[$stringKey] = $value;
            }

            $normalizedData[] = app(FilterConfigStringKeysAction::class)->execute($normalizedItem);
        }

        return $normalizedData;
    }

    /**
     * @param  array<string, mixed> $schema
     * @return array<string, mixed>
     */
    protected function normalizeSchemaFields(array $schema): array
    {
        return app(FilterConfigStringKeysAction::class)->execute($schema);
    }

    /**
     * @param  array<int, array<string, mixed>>  $normalizedData
     * @param  array<string, mixed> $form
     * @return array<int, array<string, mixed>>
     */
    protected function completeSchemaFields(array $normalizedData, array $form): array
    {
        /** @var array<int, array<string, mixed>> $completedData */
        $completedData = [];

        foreach ($normalizedData as $item) {
            foreach (array_keys($form) as $safeKey) {
                if (! array_key_exists($safeKey, $item)) {
                    $item[$safeKey] = null;
                }
            }

            ksort($item);
            $completedData[] = $item;
        }

        return array_values($completedData);
>>>>>>> 1ad0554 (.)
=======
        return array_values($completedData);
>>>>>>> .merge_file_TtozBO
    }
}
