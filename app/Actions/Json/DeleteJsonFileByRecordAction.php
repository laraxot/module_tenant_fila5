<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

<<<<<<< .merge_file_MRBhn3
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
>>>>>>> .merge_file_GBVgLG
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Array\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;
<<<<<<< .merge_file_MRBhn3

=======
use Webmozart\Assert\Assert;

/**
 * Rimuove dal file JSON la riga corrispondente al record in cancellazione.
 *
 * `getRows()` restituisce righe indicizzate per posizione, quindi la chiave va
 * recuperata da `Arr::keyBy()` sulla colonna primaria: e' la stessa coppia
 * `($keyName, $key)` che `UpdateJsonFileByRecordAction` usa per riscrivere la riga.
 */
>>>>>>> .merge_file_GBVgLG
class DeleteJsonFileByRecordAction
{
    use QueueableAction;

<<<<<<< .merge_file_MRBhn3
    public function execute(HasSushiToJson $record): void
    {
        $rows=$record->getRows();

        $key=$record->getKey();
        $keyName=$record->getKeyName();

        $keyed = Arr::keyBy($rows, $keyName);
        Arr::forget($keyed, $key);
        $filename=$record->getJsonFile();
        $keyed = app(EnsureKeysAction::class)->execute($keyed, array_keys($record->getSchema()));
        $keyed=array_values($keyed);

        app(SaveArrayAction::class)->execute($keyed,$filename,'json');

    }
}
=======
    public function execute(Model&HasSushiToJson $record): void
    {
        $rows = $record->getRows();

        $keyName = $record->getKeyName();
        $key = $record->getKey();

        Assert::integer($key);

        $keyed = Arr::keyBy($rows, $keyName);

        Arr::forget($keyed, $key);

        $keyed = app(EnsureKeysAction::class)->execute(
            $keyed,
            array_keys($record->getSchema())
        );

        $keyed = array_values($keyed);
        $filename = $record->getJsonFile();

        app(SaveArrayAction::class)->execute($keyed, $filename, 'json');
    }
}
>>>>>>> .merge_file_GBVgLG
