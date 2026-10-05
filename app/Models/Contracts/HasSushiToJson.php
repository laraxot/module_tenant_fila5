<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Contracts;

interface HasSushiToJson
{
    /**
     * non possiamo mettere :array perche' Sushi lo richiede come array<int, array<string, mixed>>
     * @return array<int, array<string, mixed>>
     */
    public function getRows();
}
