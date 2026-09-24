<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\QueueableAction\QueueableAction;

/**
 * Action per ottenere il nome del tenant basato sul server name.
 */
class GetTenantNameAction
{
    use QueueableAction;

    /**
     * Esegue l'action per ottenere il nome del tenant.
     *
     * @return string Il nome del tenant
     */
    public function execute(): string
    {
<<<<<<< HEAD
=======
        if (app()->bound('tenant.resolved_name')) {
            /** @var string $cached */
            $cached = app('tenant.resolved_name');

            return $cached;
        }

>>>>>>> 1ad0554 (.)
        $default = $this->resolveDefaultHost();

        /** @var Collection<int, string> $parts */
        $parts = $this->buildServerParts($default);

<<<<<<< HEAD
        return $this->resolveFromParts($parts)
            ?? $this->resolveFromDefaultHost($default)
            ?? 'localhost';
=======
        $tenantName = $this->resolveFromParts($parts)
            ?? $this->resolveFromDefaultHost($default)
            ?? 'localhost';

        if ($this->containsUnsafeTenantPathCharacters($tenantName)) {
            $tenantName = 'localhost';
        }

        if ($tenantName !== 'localhost' && ! $this->tenantConfigExists($tenantName)) {
            $tenantName = 'localhost';
        }

        app()->instance('tenant.resolved_name', $tenantName);

        return $tenantName;
>>>>>>> 1ad0554 (.)
    }

    private function resolveDefaultHost(): string
    {
        $default = config('app.url');

        if (! \is_string($default)) {
            $default = 'localhost';
        }

        return Str::after($default, '//');
    }

    /**
     * @return Collection<int, string>
     */
    private function buildServerParts(string $default): Collection
    {
        $serverName = Str::of($this->getServerName($default))->replace('www.', '')->toString();

        return collect(explode('.', $serverName))
            ->map(static fn (string $part): string => Str::slug($part))
            ->reverse()
            ->values();
    }

    /**
     * @param  Collection<int, string>  $parts
     */
    private function resolveFromParts(Collection $parts): ?string
    {
        if (file_exists($this->buildConfigPath($parts))) {
            return $parts->implode('/');
        }

        if ($parts->count() <= 2) {
            return null;
        }

        /** @var Collection<int, string> $shortenedParts */
        $shortenedParts = $parts->slice(0, -1);

        if (file_exists($this->buildConfigPath($shortenedParts))) {
            return $shortenedParts->implode('/');
        }

        return null;
    }

    private function resolveFromDefaultHost(string $default): ?string
    {
        $defaultPath = implode('/', array_reverse(explode('.', $default)));

        if ($defaultPath === '' || ! file_exists(base_path('config/'.$defaultPath))) {
            return null;
        }

        return $defaultPath;
    }

    /**
     * Durante LoadConfiguration le facade non sono ancora disponibili — usare getenv.
     *
     * @param  string  $default  Il valore di default da usare
     */
    private function getServerName(string $default): string
    {
        $serverName = getenv('SERVER_NAME');
<<<<<<< .merge_file_Mdmxut
<<<<<<< HEAD
        if ((! is_string($serverName) || $serverName === '') && isset($_SERVER['SERVER_NAME']) && is_string($_SERVER['SERVER_NAME'])) {
            $serverName = $_SERVER['SERVER_NAME'];
        }

=======
>>>>>>> .merge_file_MFIj11
        if (is_string($serverName) && $serverName !== '' && $serverName !== '127.0.0.1') {
=======
        if (is_string($serverName) && $serverName !== '' && $serverName !== '127.0.0.1') {
            if ($this->containsUnsafePathCharacters($serverName)) {
                return $default;
            }

>>>>>>> 1ad0554 (.)
            return $serverName;
        }

        return $default;
    }

<<<<<<< HEAD
=======
    private function containsUnsafePathCharacters(string $value): bool
    {
        return str_contains($value, '..')
            || str_contains($value, '/')
            || str_contains($value, '\\')
            || str_contains($value, "\0");
    }

    private function containsUnsafeTenantPathCharacters(string $value): bool
    {
        return str_contains($value, '..')
            || str_contains($value, '\\')
            || str_contains($value, "\0");
    }

>>>>>>> 1ad0554 (.)
    /**
     * Costruisce il percorso di configurazione.
     *
     * @param  Collection<int, string>  $parts  Le parti del percorso
<<<<<<< .merge_file_Mdmxut
<<<<<<< HEAD
=======
     *
>>>>>>> 1ad0554 (.)
=======
     *
>>>>>>> .merge_file_MFIj11
     * @return string Il percorso completo
     */
    private function buildConfigPath(Collection $parts): string
    {
        return config_path($parts->implode(DIRECTORY_SEPARATOR));
    }
<<<<<<< HEAD
=======

    private function tenantConfigExists(string $tenantName): bool
    {
        $path = config_path(str_replace('/', DIRECTORY_SEPARATOR, $tenantName));

        return is_dir($path);
    }
>>>>>>> 1ad0554 (.)
}
