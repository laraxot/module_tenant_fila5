<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Modules\Tenant\Actions\GetTenantNameAction;
use function Safe\realpath;
use Spatie\QueueableAction\QueueableAction;

class GetTenantFilePathAction
{
    use QueueableAction;

    public function execute(string $filename): string
    {
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
    }
}
