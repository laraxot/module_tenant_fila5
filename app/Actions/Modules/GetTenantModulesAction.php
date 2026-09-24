<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Modules;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
<<<<<<< HEAD
use Spatie\QueueableAction\QueueableAction;
use Throwable;

use function Safe\json_decode;

=======
use function Safe\json_decode;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

>>>>>>> 1ad0554 (.)
class GetTenantModulesAction
{
    use QueueableAction;

    /**
     * @return array<int, string>
     */
    public function execute(): array
    {
        $filePath = app(GetTenantFilePathAction::class)->execute('modules_statuses.json');
        $contents = File::get($filePath);

        try {
<<<<<<< HEAD
=======
            /** @var mixed $json */
>>>>>>> 1ad0554 (.)
            $json = json_decode($contents, true);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage().'['.$filePath.']['.__LINE__.']['.basename(__FILE__).']');
        }

        if (! \is_array($json)) {
            return [];
        }

        /** @var array<string, bool> $json */
        return $this->collectEnabledModules($json);
    }

    /**
     * @param  array<string, bool>  $json
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
     * @return array<int, string>
     */
    private function collectEnabledModules(array $json): array
    {
        $modules = [];

        foreach ($json as $name => $enabled) {
            if (! $enabled || ! \is_string($name)) {
                continue;
            }

            if (! File::exists(base_path('Modules/'.$name))) {
                continue;
            }

            $modules[] = $name;
        }

        return $modules;
    }
}
