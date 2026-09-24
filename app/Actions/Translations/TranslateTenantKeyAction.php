<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Translations;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class TranslateTenantKeyAction
{
    use QueueableAction;

    public function execute(string $key): string
    {
        $lang = app()->getLocale();

        $transFile = Str::of($key)
            ->before('.')
            ->append('.php')
            ->toString();

        $arrayKey = Str::of($key)->after('.')->toString();

        $path = app(GetTenantFilePathAction::class)->execute('lang/'.$lang.'/'.$transFile);
        if (! File::exists($path)) {
            return $key;
        }

<<<<<<< .merge_file_DpYymi
<<<<<<< HEAD
        $data = File::getRequire($path);
        Assert::isArray($data);

        $res = Arr::get($data, $arrayKey);
=======
        /** @var mixed $data */
        $data = File::getRequire($path);
        Assert::isArray($data);

=======
        /** @var mixed $data */
        $data = File::getRequire($path);
        Assert::isArray($data);

>>>>>>> .merge_file_L6u2Qq
        /** @var array<string, mixed> $arrayData */
        $arrayData = $data;

        /** @var mixed $res */
        $res = Arr::get($arrayData, $arrayKey);
<<<<<<< .merge_file_DpYymi
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_L6u2Qq

        if (! \is_string($res)) {
            return $key;
        }

        return $res;
    }
}
