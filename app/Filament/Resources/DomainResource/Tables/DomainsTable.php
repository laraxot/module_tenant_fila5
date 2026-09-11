<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DomainsTable extends XotBaseResourceTable
{
    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable()->wrap(),
            'id' => TextColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
