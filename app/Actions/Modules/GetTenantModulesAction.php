<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Modules;

use Exception;
use Illuminate\Support\Facades\File;
use Modules\Tenant\Actions\Config\GetTenantFilePathAction;
<<<<<<< .merge_file_cR2tI1
<<<<<<< HEAD
use Spatie\QueueableAction\QueueableAction;
use Throwable;

use function Safe\json_decode;

=======
use function Safe\json_decode;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

>>>>>>> 1ad0554 (.)
=======
use function Safe\json_decode;
use Spatie\QueueableAction\QueueableAction;
use Throwable;

>>>>>>> .merge_file_5x70fb
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
<<<<<<< .merge_file_cR2tI1
<<<<<<< HEAD
=======
            /** @var mixed $json */
>>>>>>> 1ad0554 (.)
=======
            /** @var mixed $json */
>>>>>>> .merge_file_5x70fb
            $json = json_decode($contents, true);
        } catch (Throwable $e) {
            throw new Exception($e->getMessage().'['.$filePath.']['.__LINE__.']['.basename(__FILE__).']');
        }

        return \is_array($json) ? $this->collectEnabledModules($json) : [];
    }

    /**
<<<<<<< .merge_file_cR2tI1
     * @param  array<string, bool>  $json
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
=======
     * @param  array<mixed, mixed>  $json
     *
>>>>>>> .merge_file_5x70fb
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
