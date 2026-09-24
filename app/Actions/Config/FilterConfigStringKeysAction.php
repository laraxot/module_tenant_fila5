<?php

declare(strict_types=1);

namespace Modules\Tenant\Actions\Config;

use Spatie\QueueableAction\QueueableAction;

final class FilterConfigStringKeysAction
{
    use QueueableAction;

    /**
<<<<<<< HEAD
     * @param  array<mixed, mixed>  $config
=======
     * @param  array<string, mixed>  $config
>>>>>>> 1ad0554 (.)
     * @return array<string, mixed>
     */
    public function execute(array $config): array
    {
        /** @var array<string, mixed> $result */
        $result = [];

        foreach ($config as $key => $value) {
            if (is_string($key)) {
                $result[$key] = $value;
            }
        }

        return $result;
    }
}
