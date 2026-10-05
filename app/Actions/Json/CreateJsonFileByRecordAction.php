<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

<<<<<<< .merge_file_GjMvAQ
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
>>>>>>> .merge_file_kW9Js2
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Array\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;
<<<<<<< .merge_file_GjMvAQ

=======
use Webmozart\Assert\Assert;

/**
 * Aggiunge al file JSON del tenant la riga corrispondente al record in creazione.
 *
 * L'id non viene assegnato dal database (Sushi usa SQLite in memoria): il
 * record riceve `max(id esistenti) + 1`. Il fallback `?: [0]` copre il file
 * vuoto, dove `max()` su array senza elementi leverebbe una ValueError.
 */
>>>>>>> .merge_file_kW9Js2
class CreateJsonFileByRecordAction
{
    use QueueableAction;

<<<<<<< .merge_file_GjMvAQ
    public function execute(HasSushiToJson $record): void
    {
        $rows=$record->getRows();
        $record->setAttribute('created_at', now());
        $record->setAttribute('updated_at', now());
        $key=$record->getKey();
        $keyName=$record->getKeyName();
        $max=max(Arr::pluck($rows, $keyName));
        $newId=$max + 1;
        $record->setAttribute($keyName, $newId);
        $rows[$newId]=$record->toArray();
        $rows = app(EnsureKeysAction::class)->execute($rows, array_keys($record->getSchema()));
        $rows=array_values($rows);
        $filename=$record->getJsonFile();
        app(SaveArrayAction::class)->execute($rows,$filename,'json');
    }

=======
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
>>>>>>> .merge_file_kW9Js2
}
