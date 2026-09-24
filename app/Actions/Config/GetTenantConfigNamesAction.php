<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\GetTenantNameAction;
use Modules\Xot\Actions\File\FixPathAction;
use Spatie\QueueableAction\QueueableAction;
<<<<<<< .merge_file_x24iYE
<<<<<<< HEAD
use Symfony\Component\Finder\SplFileInfo;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_IshLVB

class GetTenantConfigNamesAction
{
    use QueueableAction;

    /**
     * @return array<int, array{id:int,name:string}>
     */
    public function execute(): array
    {
        $name = app(GetTenantNameAction::class)->execute();

        $dir = config_path($name);
        $dir = app(FixPathAction::class)->execute($dir);

        $files = File::files($dir);

        return collect($files)
<<<<<<< .merge_file_x24iYE
<<<<<<< HEAD
            ->filter(static fn (SplFileInfo $item): bool => $item->getExtension() === 'php')
            ->map(static fn (SplFileInfo $item, int $k): array => [
=======
            ->filter(static fn ($item): bool => $item->getExtension() === 'php')
            ->map(static fn ($item, $k): array => [
>>>>>>> 1ad0554 (.)
=======
            ->filter(static fn ($item): bool => $item->getExtension() === 'php')
            ->map(static fn ($item, $k): array => [
>>>>>>> .merge_file_IshLVB
                'id' => $k + 1,
                'name' => $item->getFilenameWithoutExtension(),
            ])
            ->values()
            ->all();
    }
}
