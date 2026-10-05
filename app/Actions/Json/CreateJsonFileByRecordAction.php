<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Json;

// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Tenant\Models\Contracts\HasSushiToJson;
use Modules\Xot\Actions\Arr\EnsureKeysAction;
use Modules\Xot\Actions\Array\SaveArrayAction;
use Spatie\QueueableAction\QueueableAction;

class CreateJsonFileByRecordAction
{
    use QueueableAction;

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

}
