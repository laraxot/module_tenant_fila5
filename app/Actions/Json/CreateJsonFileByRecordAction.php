<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Array\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

/**
 * Aggiunge al file JSON del tenant la riga corrispondente al record in creazione.
 *
 * L'id non viene assegnato dal database (Sushi usa SQLite in memoria): il
 * record riceve `max(id esistenti) + 1`. Il fallback `?: [0]` copre il file
 * vuoto, dove `max()` su array senza elementi leverebbe una ValueError.
 */
class CreateJsonFileByRecordAction
{
    use QueueableAction;

    public function execute(Model&HasSushiToJson $record): void
    {
        $rows = $record->getRows();

        $record->setAttribute('created_at', now());
        $record->setAttribute('updated_at', now());

        $keyName = $record->getKeyName();

        $max = max(Arr::pluck($rows, $keyName) ?: [0]);

        Assert::integer($max);

        $newId = $max + 1;

        $record->setAttribute($keyName, $newId);

        $rows[$newId] = $record->toArray();
        $rows = app(EnsureKeysAction::class)->execute($rows, array_keys($record->getSchema()));

        $rows = array_values($rows);
        $filename = $record->getJsonFile();
        app(SaveArrayAction::class)->execute($rows, $filename, 'json');
    }
}
