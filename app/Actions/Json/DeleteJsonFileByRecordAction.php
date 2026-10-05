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

class DeleteJsonFileByRecordAction
{
    use QueueableAction;

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
