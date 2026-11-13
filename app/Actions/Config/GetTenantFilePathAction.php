<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use InvalidArgumentException;
use Modules\Tenant\Actions\GetTenantNameAction;
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
        $normalizedFilename = str_replace('\\', '/', $filename);
        if (str_starts_with($normalizedFilename, '/') || str_contains($filename, "\0") || in_array('..', explode('/', $normalizedFilename), true)) {
            throw new InvalidArgumentException('Tenant filename must be a relative path without traversal segments.');
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        $path = base_path('config/'.$tenantName.'/'.$filename);

        // I contenuti JSON (Sushi: pagine, sezioni, menu...) sono dati del sito, versionati in config/<tenant>.
        // Durante i test ogni Model::create() scriverebbe un file li' dentro e lo finirebbe in git: si usa
        // una copia usa-e-getta sotto storage. Le altre config del tenant (database.php, xra.php...) restano reali.
        if (app()->runningUnitTests() && str_starts_with($normalizedFilename, 'database/content/')) {
            $path = storage_path('framework/testing/tenant-content/'.$tenantName.'/'.$filename);
        }

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
    }
}
