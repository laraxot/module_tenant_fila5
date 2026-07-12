<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class MergeRecursiveStringKeyConfigAction
{
    use QueueableAction;

    public function __construct(
        private readonly FilterConfigStringKeysAction $filterConfigStringKeysAction,
    ) {}

    /**
     * @param  array<string, mixed>  ...$configs
     * @return array<string, mixed>
     */
    public function execute(array ...$configs): array
    {
        /** @var array<string, mixed> $merged */
        $merged = [];

        foreach ($configs as $config) {
            /** @var array<string, mixed> $merged */
            $merged = array_replace_recursive(
                $merged,
                $this->filterConfigStringKeysAction->execute($config),
            );
        }

        /** @var array<string, mixed> $filtered */
        $filtered = $this->filterConfigStringKeysAction->execute($merged);

        return $filtered;
    }
}
