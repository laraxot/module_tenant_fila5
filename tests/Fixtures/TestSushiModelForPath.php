<?php

declare(strict_types=1);

namespace Tests\Modules\Tenant\Fixtures;

use Modules\Tenant\Models\TestSushiModel;

/** Path JSON iniettabile per isolamento tenant nei test Sushi→JSON. */
final class TestSushiModelForPath extends TestSushiModel
{
    private string $jsonPath = '';

    public function setJsonPath(string $jsonPath): self
    {
        $this->jsonPath = $jsonPath;

        return $this;
    }

    public function getJsonFile(): string
    {
        return $this->jsonPath;
    }
}
