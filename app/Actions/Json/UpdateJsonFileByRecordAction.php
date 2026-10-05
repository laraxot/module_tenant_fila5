<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

<<<<<<< .merge_file_MTILsc
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
>>>>>>> .merge_file_HZ8VK2
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Array\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;
<<<<<<< .merge_file_MTILsc

=======
use Webmozart\Assert\Assert;

/**
 * Sincronizza sul file JSON la riga corrispondente al record in aggiornamento.
 *
 * Chiavizza le righe sulla colonna primaria come `DeleteJsonFileByRecordAction`,
 * cosi' la stessa coppia `($keyName, $key)` identifica la riga da sostituire
 * in scrittura e da rimuovere in cancellazione.
 */
>>>>>>> .merge_file_HZ8VK2
class UpdateJsonFileByRecordAction
{
    use QueueableAction;

<<<<<<< .merge_file_MTILsc
    public function execute(HasSushiToJson $record): void
    {
        $rows=$record->getRows();
        $record->setAttribute('updated_at', now());
        $key=$record->getKey();
        $keyName=$record->getKeyName();

        $keyed = Arr::keyBy($rows, $keyName);
        $keyed[$key]=$record->toArray();
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

        $record->setAttribute('updated_at', now());

        $keyName = $record->getKeyName();
        $key = $record->getKey();

        Assert::integer($key);

        $keyed = Arr::keyBy($rows, $keyName);

        $keyed[$key] = $record->toArray();

        $keyed = app(EnsureKeysAction::class)->execute(
            $keyed,
            array_keys($record->getSchema())
        );

        $keyed = array_values($keyed);
        $filename = $record->getJsonFile();

        app(SaveArrayAction::class)->execute($keyed, $filename, 'json');
    }
}
>>>>>>> .merge_file_HZ8VK2
