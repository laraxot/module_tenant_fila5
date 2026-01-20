<?php

declare(strict_types=1);

namespace Modules\Tenant\Providers;

use Override;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Providers\XotBaseServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Modules\Tenant\Providers\Filament\AdminPanelProvider;

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
        $map = TenantService::config('morph_map');
        if (! \is_array($map)) {
            $map = [];
        }

        /** @var array<string, class-string<Model>> $typedMap */
        $typedMap = [];
        foreach ($map as $alias => $class) {
            if (is_string($alias) && is_string($class) && class_exists($class)) {
                /** @var class-string<Model> $modelClass */
                $modelClass = $class;
                $typedMap[$alias] = $modelClass;
            }
        }

        /** @var array<string, class-string<Model>> $typedMap */
        Relation::morphMap($typedMap);
    }

    public function registerDB(): void
    {
        Schema::defaultStringLength(191);
        // Skip database purge/reconnect during testing to preserve test DB mappings
        if ($this->app->environment('testing')) {

            return;
        }

        if (Request::has('act') && Request::input('act') === 'migrate') {
            DB::purge('mysql'); // Call to a member function prepare() on null
            DB::reconnect('mysql');
        }
        $data=TenantService::config('database');
        
        
        
        $default = Arr::get($data, 'default', 'mysql');
        $connections = Arr::get($data, 'connections', []);

        
        
        $modules = Module::getOrdered();
        foreach ($modules as $module) {
            $name = $module->getSnakeName();
            if (!isset($connections[$name])) {
                $connections[$name] = $connections[$default];
            }
        }
        $data=Arr::set($data, 'connections', $connections);
        Config::set('database', $data);
        
        
         
        // DB::purge(); //Call to a member function prepare() on null
        // Database connection [mysql] not configured.
        DB::reconnect();
        
    }

    #[Override]
    public function register(): void
    {
        parent::register();
        $this->app->register(AdminPanelProvider::class);
    }

    public function mergeConfigs(): void
    {
        /*
         * dddx([
         * 'base_path' => base_path(),
         * 'path1' => realpath(__DIR__ . '/../../../'),
         * 'run' => $this->app->runningUnitTests(),
         * 'run1' => $this->app->runningInConsole(),
         * ]);
         */
        // if ($this->app->runningUnitTests()) {
        // if (base_path() !== realpath(__DIR__ . '/../../../')) {
        //     // $this->publishes([
        //     //    __DIR__ . '/../config/xra.php' => config_path('xra.php'),
        //     // ], 'config');

        //     $name = TenantService::getName();
        //     File::makeDirectory(config_path($name), 0755, true, true);

        //     $this->mergeConfigFrom(__DIR__ . '/../config/xra.php', 'xra');

        //     return;
        // }

        $configs = TenantService::getConfigNames();

        foreach ($configs as $config) {
            if (! is_array($config) || ! isset($config['name'])) {
                continue;
            }

            $configName = $config['name'];
            if (is_string($configName)) {
                $tmp = TenantService::config($configName);
            }
        }
    }
}
