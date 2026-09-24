<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class MergeRecursiveStringKeyConfigAction
{
    use QueueableAction;

<<<<<<< HEAD
    /**
<<<<<<< .merge_file_wtaZVI
     * Accetta array con chiavi di qualunque tipo: scartare quelle non stringa è
     * il compito dell'action, non una precondizione del chiamante.
     *
     * @param  array<array-key, mixed>  ...$configs
=======
    public function __construct(
        private readonly FilterConfigStringKeysAction $filterConfigStringKeysAction,
    ) {}

    /**
     * @param  array<string, mixed>  ...$configs
>>>>>>> 1ad0554 (.)
=======
     * @param  array<string, mixed>  ...$configs
>>>>>>> .merge_file_GyLd4v
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
<<<<<<< HEAD
                app(FilterConfigStringKeysAction::class)->execute($config),
=======
                $this->filterConfigStringKeysAction->execute($config),
>>>>>>> 1ad0554 (.)
            );
        }

        /** @var array<string, mixed> $filtered */
<<<<<<< HEAD
        $filtered = app(FilterConfigStringKeysAction::class)->execute($merged);
=======
        $filtered = $this->filterConfigStringKeysAction->execute($merged);
>>>>>>> 1ad0554 (.)

        return $filtered;
    }
}
