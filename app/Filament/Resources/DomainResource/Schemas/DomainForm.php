<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources\DomainResource\Schemas;

<<<<<<< HEAD
use Filament\Forms\Components\RichEditor;
=======
>>>>>>> 1ad0554 (.)
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component as SchemaComponent;
use Modules\Xot\Filament\Resources\Schemas\XotBaseResourceForm;

class DomainForm extends XotBaseResourceForm
{
    /**
     * @return array<int|string, SchemaComponent>
     */
<<<<<<< HEAD
    public function getFormSchema(): array
    {
        return [
            'title' => TextInput::make('title')
                ->required()
                ->string()
                ->maxLength(255),
            'brand' => TextInput::make('brand')
                ->required()
                ->string()
                ->maxLength(255),
            'category' => TextInput::make('category')
                ->required()
                ->string()
                ->maxLength(255),
            'description' => RichEditor::make('description')->required()->string(),
            'price' => TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('$'),
            'rating' => TextInput::make('rating')
                ->required()
                ->numeric()
                ->minValue(0)
                ->maxValue(5),
=======
    public static function getFormSchema(): array
    {
        return [
            'name' => TextInput::make('name')
                ->required()
                ->string()
                ->maxLength(255),
>>>>>>> 1ad0554 (.)
        ];
    }
}
