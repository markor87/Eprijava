<?php

namespace App\Filament\Resources\NationalMinorities;

use App\Filament\Resources\NationalMinorities\Pages\CreateNationalMinority;
use App\Filament\Resources\NationalMinorities\Pages\EditNationalMinority;
use App\Filament\Resources\NationalMinorities\Pages\ListNationalMinorities;
use App\Filament\Resources\NationalMinorities\Schemas\NationalMinorityForm;
use App\Filament\Resources\NationalMinorities\Tables\NationalMinoritiesTable;
use App\Models\NationalMinority;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class NationalMinorityResource extends Resource
{
    protected static ?string $model = NationalMinority::class;

    protected static ?string $slug = 'national-minorities';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFlag;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Националне мањине';

    protected static ?string $modelLabel = 'Национална мањина';

    protected static ?string $pluralModelLabel = 'Националне мањине';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return NationalMinorityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return NationalMinoritiesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:NationalMinority',
            'View:NationalMinority',
            'Create:NationalMinority',
            'Update:NationalMinority',
            'Delete:NationalMinority',
        ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListNationalMinorities::route('/'),
            'create' => CreateNationalMinority::route('/create'),
            'edit'   => EditNationalMinority::route('/{record}/edit'),
        ];
    }
}
