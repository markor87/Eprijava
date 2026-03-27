<?php

namespace App\Filament\Resources\GovernmentBodies;

use App\Filament\Resources\GovernmentBodies\Pages\CreateGovernmentBody;
use App\Filament\Resources\GovernmentBodies\Pages\EditGovernmentBody;
use App\Filament\Resources\GovernmentBodies\Pages\ListGovernmentBodies;
use App\Filament\Resources\GovernmentBodies\Schemas\GovernmentBodyForm;
use App\Filament\Resources\GovernmentBodies\Tables\GovernmentBodiesTable;
use App\Models\GovernmentBody;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class GovernmentBodyResource extends Resource
{
    protected static ?string $model = GovernmentBody::class;

    protected static ?string $slug = 'government-bodies';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Државни органи';

    protected static ?string $modelLabel = 'Државни орган';

    protected static ?string $pluralModelLabel = 'Државни органи';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return GovernmentBodyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GovernmentBodiesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:GovernmentBody',
            'View:GovernmentBody',
            'Create:GovernmentBody',
            'Update:GovernmentBody',
            'Delete:GovernmentBody',
        ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListGovernmentBodies::route('/'),
            'create' => CreateGovernmentBody::route('/create'),
            'edit'   => EditGovernmentBody::route('/{record}/edit'),
        ];
    }
}
