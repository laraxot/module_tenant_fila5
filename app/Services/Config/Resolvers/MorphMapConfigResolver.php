<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config\Resolvers;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
=======
<<<<<<< .merge_file_DtWKCc
use Modules\Tenant\Services\Config\ConfigStringKeyFilter;
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Modules\Xot\Services\RouteService;
=======
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\TenantService;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
>>>>>>> 1ad0554 (.)

/**
 * Resolves morph_map configuration for admin panel.
 */
class MorphMapConfigResolver implements ConfigResolverInterface
{
    public function canResolve(string $key): bool
    {
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
<<<<<<< .merge_file_DtWKCc
        return RouteService::inAdmin()
=======
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
        // Ex RouteService::inAdmin() (Services archiviato): main panel `/admin/...`.
        // NB: semantica diversa dall'helper globale inAdmin() (module panel `/{module}/admin`).
        $segments = Request::segments();
        $inMainAdmin = Request::segment(1) === 'admin'
            || (\count($segments) > 0 && $segments[0] === 'livewire' && session('in_admin', false) === true);

        return $inMainAdmin
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
            && Str::startsWith($key, 'morph_map')
            && Request::segment(2) !== null;
    }

<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
<<<<<<< .merge_file_DtWKCc
=======
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
    /**
     * @param  string|int|array<string, mixed>|null  $default
     * @return float|int|string|array<mixed>|null
     */
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
    public function resolve(string $key, string|int|array|null $default = null): float|int|string|array|null
    {
        $moduleName = Request::segment(2);
        if (! is_string($moduleName)) {
            throw new Exception('Invalid module name from request segment');
        }

<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
        // Use action directly instead of helper function to avoid autoload issues during package:discover
=======
<<<<<<< .merge_file_DtWKCc
=======
        // Use action directly instead of helper function to avoid autoload issues during package:discover
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
        // Use action directly instead of helper function to avoid autoload issues during package:discover
>>>>>>> 1ad0554 (.)
        /** @var GetAllModelsByModuleNameAction $action */
        $action = app(GetAllModelsByModuleNameAction::class);
        /** @var array<string, class-string> $models */
        $models = $action->execute($moduleName);
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
<<<<<<< .merge_file_DtWKCc

        /** @var array<string, mixed> $mergedConf */
        $mergedConf = array_merge($models, $this->getOriginalConfig(), $this->getTenantConfig());

        Config::set('morph_map', $mergedConf);

        $result = $this->fetchValidatedMorphMap($key);

        if ($result === null) {
            return $default;
        }

        return $result;
    }

    /**
     * @return float|int|string|array<mixed>|null
     */
    private function fetchValidatedMorphMap(string $key): float|int|string|array|null
    {
        $result = config($key);

        if ($result === null) {
            return null;
        }

        if (is_array($result)) {
            return $result;
        }

        if (is_numeric($result)) {
            return $result;
        }

        if (is_string($result)) {
            return $result;
        }

        return null;
=======
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
        $originalConf = $this->getOriginalConfig();
        $tenantConf = $this->getTenantConfig();

        // Use array_merge to avoid PHPStan type issues with Collection::merge()
        /** @var array<string, mixed> $mergedConf */
        $mergedConf = array_merge($models, $originalConf, $tenantConf);

        Config::set('morph_map', $mergedConf);

        $result = config($key);

        if (! is_numeric($result) && ! is_string($result) && ! is_array($result)) {
            throw new Exception('Invalid morph_map configuration type');
        }

        return $result;
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
    }

    /**
     * @return array<string, mixed>
     */
    private function getOriginalConfig(): array
    {
        $config = config('morph_map');
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
<<<<<<< .merge_file_DtWKCc

        if (is_array($config)) {
            /** @var array<string, mixed> $config */
            return ConfigStringKeyFilter::onlyStringKeys($config);
        }

        return [];
=======
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
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
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
    }

    /**
     * @return array<string, mixed>
     */
    private function getTenantConfig(): array
    {
        $path = TenantService::filePath('morph_map.php');

        if (! File::exists($path)) {
            return [];
        }

        $config = File::getRequire($path);
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
<<<<<<< .merge_file_DtWKCc

        if (is_array($config)) {
            /** @var array<string, mixed> $config */
            return ConfigStringKeyFilter::onlyStringKeys($config);
        }

        return [];
=======
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
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
<<<<<<< HEAD
<<<<<<< .merge_file_eSv7Sp
=======
>>>>>>> .merge_file_Jgp7N9
>>>>>>> .merge_file_AcCQKc
=======
>>>>>>> 1ad0554 (.)
    }
}
