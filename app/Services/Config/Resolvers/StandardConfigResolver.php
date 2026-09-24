<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
<<<<<<< .merge_file_x6VAt5
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
=======
<<<<<<< .merge_file_eSHye0
use Illuminate\Support\Facades\Config;
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
=======
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;

/**
 * Resolves standard tenant configuration by merging original and tenant-specific configs.
 */
class StandardConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
<<<<<<< .merge_file_x6VAt5
=======
<<<<<<< .merge_file_eSHye0
        return $key !== '';
    }

    /**
     * @param  string|int|array<mixed>|null  $default
=======
>>>>>>> .merge_file_UMrSw5
        // This is the fallback resolver, it can handle any key
        return true;
    }

    /**
     * @param  string|int|array<string, mixed>|null  $default
<<<<<<< .merge_file_x6VAt5
=======
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
     * @return float|int|string|array<mixed>|null
     */
    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        $group = $this->extractGroup($key);
<<<<<<< .merge_file_x6VAt5
=======
<<<<<<< .merge_file_eSHye0
        $mergedConf = $this->buildMergedConfig($key, $group);

        Config::set($group, $mergedConf);

        return $this->fetchValidatedConfig($key, $default);
    }

    /**
     * @return array<string, mixed>
     */
    private function buildMergedConfig(string $key, string $group): array
    {
        $originalConf = $this->getOriginalConfig($group);
        $extraConf = $this->getTenantConfig($group);

        if ($key === 'database') {
            $extraConf = $this->resolveDatabaseExtraConfig($extraConf);
        }

        return collect($originalConf)->merge($extraConf)->all();
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @return array<string, mixed>
     */
    private function resolveDatabaseExtraConfig(array $extraConf): array
    {
        $databaseResolver = new DatabaseConfigResolver;
        $resolved = $databaseResolver->resolve('database', $extraConf);

        if (! is_array($resolved)) {
            return [];
        }

        return $resolved;
    }

    /**
     * @param  string|int|array<mixed>|null  $default
     * @return float|int|string|array<mixed>|null
     */
    private function fetchValidatedConfig(string $key, string|int|array|null $default): float|int|string|array|null
    {
        $result = config($key);

        if ($result === null && $default !== null) {
            $this->handleMissingConfig($key);
=======
>>>>>>> .merge_file_UMrSw5

        $originalConf = $this->getOriginalConfig($group);
        $extraConf = $this->getTenantConfig($group);

        // Handle database configuration specially
        if ($key === 'database') {
<<<<<<< .merge_file_x6VAt5
            $databaseResolver = new DatabaseConfigResolver();
=======
            $databaseResolver = new DatabaseConfigResolver;
>>>>>>> .merge_file_UMrSw5
            $resolvedDatabaseConfig = $databaseResolver->resolve($key, $extraConf);
            $extraConf = is_array($resolvedDatabaseConfig) ? $resolvedDatabaseConfig : [];
        }

        $mergedConf = collect($originalConf)->merge($extraConf)->all();
        Config::set($group, $mergedConf);

        $result = config($key);

        if ($result === null && $default !== null) {
            $this->handleMissingConfig($key, $group, $extraConf, $default);
<<<<<<< .merge_file_x6VAt5
=======
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
        }

        if (! is_numeric($result) && ! is_string($result) && ! is_array($result) && $result !== null) {
            throw new Exception('Invalid configuration type for key: '.$key);
        }

        return $result;
    }

    private function extractGroup(string $key): string
    {
<<<<<<< .merge_file_x6VAt5
        return explode('.', $key)[0];
=======
<<<<<<< .merge_file_eSHye0
        $group = collect(explode('.', $key))->first();

        if ($group === null) {
            throw new Exception('Invalid configuration key: '.$key);
        }

        return $group;
=======
        return explode('.', $key)[0];
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(string $group): array
    {
        $config = config($group);
<<<<<<< .merge_file_x6VAt5
=======
<<<<<<< .merge_file_eSHye0

        if (is_array($config)) {
            /** @var array<string, mixed> $config */
            return ConfigStringKeyFilter::onlyStringKeys($config);
        }

        return [];
=======
>>>>>>> .merge_file_UMrSw5
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
<<<<<<< .merge_file_x6VAt5
=======
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
    }

    /**
     * @return array<string, mixed>
     */
    private function getTenantConfig(string $group): array
    {
        $tenantName = TenantService::getName();
        $configName = str_replace('/', '.', $tenantName).'.'.$group;
        $config = config($configName);
<<<<<<< .merge_file_x6VAt5
=======
<<<<<<< .merge_file_eSHye0

        if (is_array($config)) {
            /** @var array<string, mixed> $config */
            return ConfigStringKeyFilter::onlyStringKeys($config);
        }

        return [];
    }

    private function handleMissingConfig(string $key): void
    {
=======
>>>>>>> .merge_file_UMrSw5
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
     * @param  array<string, mixed>  $extraConf
     * @param  string|int|array<string, mixed>|null  $default
     */
    private function handleMissingConfig(
        string $key,
        string $group,
        array $extraConf,
        string|int|array|null $default
    ): void {
        $index = Str::after($key, $group.'.');
        // Side-effect reserved for future persist of defaults into $extraConf
        Arr::set($extraConf, $index, $default);

<<<<<<< .merge_file_x6VAt5
=======
>>>>>>> .merge_file_vwEq3W
>>>>>>> .merge_file_UMrSw5
        throw new Exception('Configuration key not found: '.$key);
    }
}
