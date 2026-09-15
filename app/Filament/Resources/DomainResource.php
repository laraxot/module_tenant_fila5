<?php

declare(strict_types=1);

namespace Modules\Tenant\Filament\Resources;

use Modules\Tenant\Filament\Resources\DomainResource\Pages\CreateDomain;
use Modules\Tenant\Filament\Resources\DomainResource\Pages\EditDomain;
use Modules\Tenant\Filament\Resources\DomainResource\Pages\ListDomains;
use Modules\Tenant\Models\Domain;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class DomainResource extends XotBaseResource
{
    protected static ?string $model = Domain::class;

<<<<<<< HEAD
=======
    /**
     * @return array<string, mixed>
     */
    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

>>>>>>> laraxot/dev
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListDomains::route('/'),
            'create' => CreateDomain::route('/create'),
            'edit' => EditDomain::route('/{record}/edit'),
        ];
    }
}
