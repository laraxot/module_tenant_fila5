<?php

declare(strict_types=1);

namespace Modules\Tenant\Services\Config;

use Modules\Tenant\Services\Config\Contracts\ConfigResolverInterface;
use Modules\Tenant\Services\Config\Resolvers\DatabaseConfigResolver;
use Modules\Tenant\Services\Config\Resolvers\MorphMapConfigResolver;
use Modules\Tenant\Services\Config\Resolvers\StandardConfigResolver;

/**
 * Registry for configuration resolvers.
 */
class ConfigResolverRegistry
{
    /**
     * @var array<ConfigResolverInterface>
     */
    private array $resolvers = [];

    public function __construct()
    {
        $this->registerDefaultResolvers();
    }

    /**
     * Register a configuration resolver.
     */
    public function register(ConfigResolverInterface $resolver): self
    {
        $this->resolvers[] = $resolver;

        return $this;
    }

    /**
     * Find a resolver for the given configuration key.
     */
    public function findResolver(string $key): ConfigResolverInterface
    {
        foreach ($this->resolvers as $resolver) {
            if ($resolver->canResolve($key)) {
                return $resolver;
            }
        }

        // Fallback to standard resolver
<<<<<<< HEAD
<<<<<<< .merge_file_MKeudE
        return new StandardConfigResolver();
=======
<<<<<<< .merge_file_raXIcS
        return new StandardConfigResolver();
=======
        return new StandardConfigResolver;
>>>>>>> .merge_file_rP0BUN
>>>>>>> .merge_file_9Kbs2q
=======
        return new StandardConfigResolver();
>>>>>>> 1ad0554 (.)
    }

    /**
     * Register all default configuration resolvers.
     * Order matters: more specific resolvers should be registered first.
     */
    private function registerDefaultResolvers(): void
    {
<<<<<<< HEAD
<<<<<<< .merge_file_MKeudE
        $this->register(new MorphMapConfigResolver())
            ->register(new DatabaseConfigResolver())
            ->register(new StandardConfigResolver());
=======
<<<<<<< .merge_file_raXIcS
        $this->register(new MorphMapConfigResolver())
            ->register(new DatabaseConfigResolver())
            ->register(new StandardConfigResolver());
=======
        $this->register(new MorphMapConfigResolver)
            ->register(new DatabaseConfigResolver)
            ->register(new StandardConfigResolver);
>>>>>>> .merge_file_rP0BUN
>>>>>>> .merge_file_9Kbs2q
=======
        $this->register(new MorphMapConfigResolver())
            ->register(new DatabaseConfigResolver())
            ->register(new StandardConfigResolver());
>>>>>>> 1ad0554 (.)
    }
}
