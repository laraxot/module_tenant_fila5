<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
<<<<<<< .merge_file_aU4fjJ
<<<<<<< HEAD
use Modules\Tenant\Models\Domain;
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_La1yyS
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class DomainsTable extends XotBaseResourceTable
{
    /**
<<<<<<< .merge_file_aU4fjJ
<<<<<<< HEAD
     * @var class-string<Domain>
     */
    protected static string $model = Domain::class;

    /**
=======
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_La1yyS
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
<<<<<<< .merge_file_aU4fjJ
<<<<<<< HEAD
            'name' => TextColumn::make('name')->searchable()->sortable()->wrap(),
            'id' => TextColumn::make('id')->toggleable(isToggledHiddenByDefault: true),
=======
=======
>>>>>>> .merge_file_La1yyS
            'id' => TextColumn::make('id')->sortable(),
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable(),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
<<<<<<< .merge_file_aU4fjJ
>>>>>>> 1ad0554 (.)
=======
>>>>>>> .merge_file_La1yyS
        ];
    }
}
