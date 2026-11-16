<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Safe\Exceptions\FilesystemException;
use Spatie\QueueableAction\QueueableAction;

use function Safe\realpath;

/**
 * Ricava il nome tenant dall'host (SERVER_NAME / app.url).
 *
 * Pattern: dominio invertito e slugato (`foo.example.com` → `com/example/foo`), poi lookup
 * in `config/<path>`. Se l'host è un symlink (es. `eu/fixcity` → `local/fixcity`), la chiave
 * di config deve usare il path reale, non l'alias — altrimenti Laravel non trova i file.
 */
class GetTenantNameAction
{
    use QueueableAction;

    public function execute(): string
    {
        $default = config('app.url');

        if (! \is_string($default)) {
            $default = 'localhost';
        }

        $default = Str::after($default, '//');

        $server_name = $this->getServerName($default);
        $server_name = Str::of($server_name)->replace('www.', '')->toString();

        /** @var Collection<int, string> $parts */
        $parts = collect(explode('.', $server_name))
            ->map(fn (string $part): string => Str::slug($part))
            ->reverse()
            ->values();

        return $this->resolveFromParts($parts)
            ?? $this->resolveFromDefaultHost($default)
            ?? 'localhost';
    }

    /**
     * @param  Collection<int, string>  $parts
     */
    private function resolveFromParts(Collection $parts): ?string
    {
        $path = $this->buildConfigPath($parts);
        if (file_exists($path)) {
            return $this->tenantNameFromPath($path);
        }

        if ($parts->count() <= 2) {
            return null;
        }

        /** @var Collection<int, string> $shortenedParts */
        $shortenedParts = $parts->slice(0, -1);
        $shortenedPath = $this->buildConfigPath($shortenedParts);

        if (file_exists($shortenedPath)) {
            return $this->tenantNameFromPath($shortenedPath);
        }

        return null;
    }

    private function resolveFromDefaultHost(string $default): ?string
    {
        $defaultPath = implode('/', array_reverse(explode('.', $default)));
        $path = base_path('config/'.$defaultPath);

        if ($defaultPath === '' || ! file_exists($path)) {
            return null;
        }

        return $this->tenantNameFromPath($path);
    }

    /**
     * Un host può essere un symlink verso la config già caricata da Laravel.
     * La chiave di config usa il path reale (`local/fixcity`), non l'alias (`eu/fixcity`).
     */
    private function tenantNameFromPath(string $path): string
    {
        try {
            $real = realpath($path);
            $configRoot = realpath(config_path());
        } catch (FilesystemException) {
            return $this->logicalTenantName($path);
        }

        $prefix = $configRoot.DIRECTORY_SEPARATOR;
        if (! str_starts_with($real, $prefix)) {
            return $this->logicalTenantName($path);
        }

        return str_replace(DIRECTORY_SEPARATOR, '/', substr($real, strlen($prefix)));
    }

    private function logicalTenantName(string $path): string
    {
        $relative = ltrim(substr($path, strlen(config_path())), DIRECTORY_SEPARATOR);

        return str_replace(DIRECTORY_SEPARATOR, '/', $relative);
    }

    private function getServerName(string $default): string
    {
        if (
            isset($_SERVER['SERVER_NAME']) &&
                $_SERVER['SERVER_NAME'] !== '127.0.0.1' &&
                is_string($_SERVER['SERVER_NAME'])
        ) {
            return $_SERVER['SERVER_NAME'];
        }

        return $default;
    }

    /**
     * @param  Collection<int, string>  $parts
     */
    private function buildConfigPath(Collection $parts): string
    {
        return config_path($parts->implode(DIRECTORY_SEPARATOR));
    }
}
