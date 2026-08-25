<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class MergeRecursiveStringKeyConfigAction
{
    use QueueableAction;

    /**
     * Le chiavi non-stringa vengono scartate da `FilterConfigStringKeysAction`: il
     * parametro accetta quindi qualsiasi chiave, altrimenti il filtro non avrebbe
     * niente da filtrare e il chiamante dovrebbe pulire l'array prima di chiamare.
     *
     * @param  array<array-key, mixed>  ...$configs
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
                app(FilterConfigStringKeysAction::class)->execute($config),
            );
        }

        /** @var array<string, mixed> $filtered */
        $filtered = app(FilterConfigStringKeysAction::class)->execute($merged);

        return $filtered;
    }
}
