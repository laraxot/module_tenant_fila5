<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;
use Modules\Tenant\Actions\Config\FilterConfigStringKeysAction;
use Modules\Tenant\Actions\Config\GetTenantConfigNamesAction;
use Modules\Tenant\Actions\Config\ResolveTenantConfigValueAction;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Laravel\Module as LaravelModule;
use Override;

class TenantServiceProvider extends XotBaseServiceProvider
{
    public string $name = 'Tenant';

    protected string $module_dir = __DIR__;

    protected string $module_ns = __NAMESPACE__;

    #[Override]
    public function boot(): void
    {
        parent::boot();

        // Skip complex configuration during testing
        // if (! $this->app->environment('testing')) {
        $this->mergeConfigs();
        // }

        $this->registerDB();
        $this->registerMorphMap();
        $this->publishConfig();
    }

    public function publishConfig(): void
    {
        // ---
    }

    public function registerMorphMap(): void
    {
        $map = app(ResolveTenantConfigValueAction::class)->execute('morph_map');
        if (! \is_array($map)) {
            $map = [];
        }

        /** @var array<string, mixed> $map */
        Relation::morphMap($this->buildMorphMap(app(FilterConfigStringKeysAction::class)->execute($map)));
    }

    public function registerDB(): void
    {
        Schema::defaultStringLength(191);

<<<<<<< HEAD
        $preMergeDefaultConn = $this->resolveDefaultConnectionName();
        $this->purgeConnectionWhenMigrating($preMergeDefaultConn);
=======
        $preMergeDefaultRaw = Config::get('database.default');
        $preMergeDefaultConn = \is_string($preMergeDefaultRaw) && $preMergeDefaultRaw !== '' ? $preMergeDefaultRaw : 'mysql';

        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge($preMergeDefaultConn); // Call to a member function prepare() on null
            DB::reconnect($preMergeDefaultConn);
        }
>>>>>>> provtv/dev

        /** @var array<string, mixed> $data */
        $data = $this->loadTenantDatabaseConfig($preMergeDefaultConn);
        $data = Arr::set($data, 'connections', $this->mergeModuleConnections($data, $preMergeDefaultConn));

<<<<<<< HEAD
        Config::set('database', $data);
        $this->reconnectDatabaseUnlessTesting();
=======
        /** @var array<string, array|float|int|string|null> $data */
        $data = is_array($raw) ? $raw : [];

        /** @var array<string, array|float|int|string|null> $connections */
        $connections = [];

        $defaultRaw = Arr::get($data, 'default', 'mysql');
        /** @var string $default */
        $default = is_string($defaultRaw) ? $defaultRaw : 'mysql';

        if (Arr::get($data, 'connections.user', null) === null) {
            Arr::set($data, 'connections.user', Arr::get($data, 'connections.user_'.$default));
        }

        /** @var array|float|int|string|null $connectionsRaw */
        $connectionsRaw = Arr::get($data, 'connections', []);
        $connections = is_array($connectionsRaw) ? $connectionsRaw : [];

        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();
            $upperName = strtoupper($name);

            if (isset($connections[$default]) && ! isset($connections[$name])) {
                /** @var array<string, mixed> $moduleConfig */
                $moduleConfig = $connections[$default];

                // Note: Module-specific env variables disabled for SQLite compatibility
                // If needed, uncomment and adjust for your database driver:
                // $moduleConfig['database'] = env("DB_DATABASE_{$upperName}", $moduleConfig['database']);
                // $moduleConfig['username'] = env("DB_USERNAME_{$upperName}", $moduleConfig['username']);
                // $moduleConfig['password'] = env("DB_PASSWORD_{$upperName}", $moduleConfig['password']);
                // $moduleConfig['host'] = env("DB_HOST_{$upperName}", $moduleConfig['host'] ?? '127.0.0.1');
                // $moduleConfig['port'] = env("DB_PORT_{$upperName}", $moduleConfig['port'] ?? '3306');

                $connections[$name] = $moduleConfig;
            }
        }

        $data = Arr::set($data, 'connections', $connections);
        Config::set('database', $data);

        // Skip purge/reconnect during testing to preserve test DB mappings
        if (! $this->app->environment('testing')) {
            // Call to a member function prepare() on null — connessione default da .env (mariadb|mysql ecc.)
            $purgeConnRaw = Config::get('database.default');
            $purgeConnName = \is_string($purgeConnRaw) && $purgeConnRaw !== '' ? $purgeConnRaw : 'mysql';
            DB::purge($purgeConnName);
            DB::reconnect();
        }
>>>>>>> provtv/dev
    }

    #[Override]
    public function register(): void
    {
        parent::register();
        // $this->app->register(AdminPanelProvider::class);
    }

    public function mergeConfigs(): void
    {
        $configs = app(GetTenantConfigNamesAction::class)->execute();

        foreach ($configs as $config) {
            if (! is_array($config) || ! isset($config['name'])) {
                continue;
            }

            $configName = $config['name'];
            if (is_string($configName)) {
                app(ResolveTenantConfigValueAction::class)->execute($configName);
            }
        }
    }

    private function resolveDefaultConnectionName(): string
    {
        $preMergeDefaultRaw = Config::get('database.default');

        return \is_string($preMergeDefaultRaw) && $preMergeDefaultRaw !== '' ? $preMergeDefaultRaw : 'mysql';
    }

    private function purgeConnectionWhenMigrating(string $connectionName): void
    {
        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge($connectionName);
            DB::reconnect($connectionName);
        }
    }

    /**
     * @return array<string, mixed>
     */
    private function loadTenantDatabaseConfig(string $preMergeDefaultConn): array
    {
        $raw = app(ResolveTenantConfigValueAction::class)->execute('database');
        /** @var array<string, mixed> $data */
        $data = is_array($raw) ? $raw : [];

        $defaultRaw = Arr::get($data, 'default', $preMergeDefaultConn);
        $default = is_string($defaultRaw) ? $defaultRaw : 'mysql';
        $data = Arr::set($data, 'default', $default);

        if (Arr::get($data, 'connections.user', null) === null) {
            Arr::set($data, 'connections.user', Arr::get($data, 'connections.user_'.$default));
        }

        return app(FilterConfigStringKeysAction::class)->execute($data);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function mergeModuleConnections(array $data, string $defaultConnection): array
    {
        /** @var array<string, mixed> $connectionsRaw */
        $connectionsRaw = Arr::get($data, 'connections', []);
        /** @var array<string, mixed> $connections */
        $connections = is_array($connectionsRaw) ? $connectionsRaw : [];

        foreach (Module::getOrdered() as $module) {
            if (! $module instanceof LaravelModule) {
                continue;
            }

            $name = $module->getSnakeName();
            if (isset($connections[$defaultConnection]) && ! isset($connections[$name])) {
                /** @var array<string, mixed> $moduleConfig */
                $moduleConfig = $connections[$defaultConnection];
                $connections[$name] = $moduleConfig;
            }
        }

        return $connections;
    }

    private function reconnectDatabaseUnlessTesting(): void
    {
        if ($this->app->environment('testing')) {
            return;
        }

        $purgeConnRaw = Config::get('database.default');
        $purgeConnName = \is_string($purgeConnRaw) && $purgeConnRaw !== '' ? $purgeConnRaw : 'mysql';
        DB::purge($purgeConnName);
        DB::reconnect();
    }

    /**
     * @param  array<string, mixed>  $map
     * @return array<string, class-string<Model>>
     */
    private function buildMorphMap(array $map): array
    {
        /** @var array<string, class-string<Model>> $typedMap */
        $typedMap = [];

        foreach ($map as $alias => $class) {
            if (! is_string($alias) || ! is_string($class) || ! class_exists($class)) {
                continue;
            }

            /** @var class-string<Model> $modelClass */
            $modelClass = $class;
            $typedMap[$alias] = $modelClass;
        }

        return $typedMap;
    }
}
