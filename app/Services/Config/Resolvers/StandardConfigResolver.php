<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;

/**
 * Resolves standard tenant configuration by merging original and tenant-specific configs.
 */
class StandardConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
        // This is the fallback resolver, it can handle any key
        return true;
    }

    /**
     * @param  string|int|array<mixed>|null  $default
     * @return float|int|string|array<mixed>|null
     */
    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        $group = $this->extractGroup($key);

        $originalConf = $this->getOriginalConfig($group);
        $extraConf = $this->getTenantConfig($group);

        // Handle database configuration specially
        if ($key === 'database') {
            $databaseResolver = new DatabaseConfigResolver;
            $extraConf = $databaseResolver->resolve($key, $extraConf);

            if (! is_array($extraConf)) {
                $extraConf = [];
            }
        }

        $mergedConf = collect($originalConf)->merge($extraConf)->all();
        Config::set($group, $mergedConf);

        $result = config($key);

        if ($result === null && $default !== null) {
            $this->handleMissingConfig($key);
        }

        if (! is_numeric($result) && ! is_string($result) && ! is_array($result) && $result !== null) {
            throw new Exception('Invalid configuration type for key: '.$key);
        }

        return $result;
    }

    private function extractGroup(string $key): string
    {
        $group = collect(explode('.', $key))->first();

        if ($group === null) {
            throw new Exception('Invalid configuration key: '.$key);
        }

        return $group;
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(string $group): array
    {
        $config = config($group);
        if (! is_array($config)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * @return array<string, mixed>
     */
    private function getTenantConfig(string $group): array
    {
        $tenantName = TenantService::getName();
        $configName = str_replace('/', '.', $tenantName).'.'.$group;
        $config = config($configName);
        if (! is_array($config)) {
            return [];
        }

        /** @var array<string, mixed> $result */
        $result = [];
        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }

    /**
     * Una chiave assente con un default esplicito e' un errore (comportamento storico mantenuto).
     * Il salvataggio del default nella config del tenant non e' mai stato attivato.
     */
    private function handleMissingConfig(string $key): never
    {
        throw new Exception('Configuration key not found: '.$key);
    }
}
