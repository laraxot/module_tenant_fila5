<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Illuminate\Support\Arr;
<<<<<<< HEAD
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
=======
use Illuminate\Support\Collection;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Nwidart\Modules\Facades\Module;
>>>>>>> laraxot/dev

/**
 * Resolves database configuration with module-specific connections.
 */
class DatabaseConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
        return $key === 'database';
    }

    /**
<<<<<<< HEAD
     * @param  array<string, mixed>  $extraConf
     *
     * @return array<string, mixed>
=======
     * @param  string|int|array<string, mixed>|null  $extraConf
     * @return float|int|string|array<string, mixed>|null
>>>>>>> laraxot/dev
     */
    public function resolve(string $key, string|int|array|null $extraConf = null): float|int|string|array|null
    {
        if (! is_array($extraConf)) {
            return null;
        }

<<<<<<< HEAD
        if ($key !== 'database') {
            return null;
        }

        $originalConf = config('database');
        if (is_array($originalConf)) {
            /** @var array<string, mixed> $originalConf */
            $originalConfTyped = ConfigStringKeyFilter::onlyStringKeys($originalConf);
        } else {
            $originalConfTyped = [];
=======
        $originalConf = config('database');
        if (! is_array($originalConf)) {
            $originalConf = [];
        }

        /** @var array<string, mixed> $originalConfTyped */
        $originalConfTyped = [];
        foreach ($originalConf as $key => $value) {
            if (is_string($key)) {
                $originalConfTyped[$key] = $value;
            }
>>>>>>> laraxot/dev
        }

        $default = $this->resolveDefaultConnection($extraConf, $originalConfTyped);

        return $this->addModuleConnections($extraConf, $default);
    }

    /**
     * @param  array<string, mixed>  $extraConf
     * @param  array<string, mixed>  $originalConf
     */
    private function resolveDefaultConnection(array $extraConf, array $originalConf): ?string
    {
<<<<<<< HEAD
        $default = Arr::get($extraConf, 'default') ?? Arr::get($originalConf, 'default') ?? config('database.default');
=======
        $default = Arr::get($extraConf, 'default');

        if ($default === null) {
            $default = Arr::get($originalConf, 'default');
        }

        if ($default === null) {
            $default = config('database.default');
        }
>>>>>>> laraxot/dev

        return is_string($default) ? $default : null;
    }

    /**
     * @param  array<string, mixed>  $extraConf
<<<<<<< HEAD
     *
=======
>>>>>>> laraxot/dev
     * @return array<string, mixed>
     */
    private function addModuleConnections(array $extraConf, ?string $default): array
    {
        if ($default === null) {
            return $extraConf;
        }

<<<<<<< HEAD
        $connectionsRaw = Arr::get($extraConf, 'connections');

        if (! is_array($connectionsRaw)) {
            return $extraConf;
        }

        /** @var array<string, mixed> $connectionsRaw */
        $connections = ConfigStringKeyFilter::onlyStringKeys($connectionsRaw);

        foreach (Module::getOrdered() as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();

            if (isset($connections[$name])) {
                continue;
            }

            $template = Arr::get($connections, $default);
            if ($template === null) {
                continue;
            }

            $connections[$name] = $template;
        }

        $extraConf['connections'] = $connections;

=======
        /** @var Collection<int, \Nwidart\Modules\Module> */
        $modules = Module::toCollection();

        foreach ($modules as $module) {
            $name = $module->getSnakeName();

            if (! isset($extraConf['connections']) || ! is_array($extraConf['connections'])) {
                continue;
            }

            if (isset($extraConf['connections'][$name])) {
                continue;
            }

            if (! isset($extraConf['connections'][$default])) {
                continue;
            }

            $extraConf['connections'][$name] = $extraConf['connections'][$default];
        }

>>>>>>> laraxot/dev
        return $extraConf;
    }
}
