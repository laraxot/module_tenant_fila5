<?php

declare(strict_types=1);

namespace Modules\Tenant\Models;

use Modules\Tenant\Models\Traits\SushiToJsons;

/**
 * Class BaseModelJsons.
 *
<<<<<<< HEAD
 * @property array<string, mixed> $form
=======
 * @property array $form
>>>>>>> provtv/dev
 * @property array<string, mixed> $schema
 */
abstract class BaseModelJsons extends BaseModel
{
    use SushiToJsons;
}
