<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

<<<<<<< HEAD
use InvalidArgumentException;
use Modules\Tenant\Actions\GetTenantNameAction;
=======
use Modules\Tenant\Actions\GetTenantNameAction;
use function Safe\realpath;
>>>>>>> 1ad0554 (.)
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
<<<<<<< HEAD
        $normalizedFilename = str_replace('\\', '/', $filename);
        if (str_starts_with($normalizedFilename, '/') || str_contains($filename, "\0") || in_array('..', explode('/', $normalizedFilename), true)) {
            throw new InvalidArgumentException('Tenant filename must be a relative path without traversal segments.');
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        $path = base_path('config/'.$tenantName.'/'.$filename);

        return str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
=======
        if ($this->containsUnsafePathCharacters($filename)) {
            throw new \InvalidArgumentException('Unsafe filename in tenant path');
        }

        if (isRunningTestBench()) {
            $basePath = realpath(__DIR__.'/../../Config');

            return $basePath.\DIRECTORY_SEPARATOR.$filename;
        }

        $tenantName = app(GetTenantNameAction::class)->execute();
        if ($this->containsUnsafePathCharacters($tenantName)) {
            throw new \RuntimeException('Path traversal detected in tenant name');
        }

        $path = base_path('config/'.$tenantName.'/'.$filename);
        $normalized = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], $path);
        $this->assertPathWithinConfigRoot($normalized);

        return $normalized;
    }

    private function containsUnsafePathCharacters(string $value): bool
    {
        return str_contains($value, '..')
            || str_contains($value, "\0");
    }

    private function assertPathWithinConfigRoot(string $path): void
    {
        $configRoot = str_replace(['/', '\\'], [\DIRECTORY_SEPARATOR, \DIRECTORY_SEPARATOR], config_path());

        if (! str_starts_with($path, $configRoot)) {
            throw new \RuntimeException('Path traversal detected in tenant file path');
        }
>>>>>>> 1ad0554 (.)
    }
}
