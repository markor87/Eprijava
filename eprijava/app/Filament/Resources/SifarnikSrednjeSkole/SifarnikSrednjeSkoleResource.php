<?php

namespace App\Filament\Resources\SifarnikSrednjeSkole;

use App\Filament\Resources\SifarnikSrednjeSkole\Pages\CreateSifarnikSrednjeSkole;
use App\Filament\Resources\SifarnikSrednjeSkole\Pages\EditSifarnikSrednjeSkole;
use App\Filament\Resources\SifarnikSrednjeSkole\Pages\ListSifarnikSrednjeSkole;
use App\Filament\Resources\SifarnikSrednjeSkole\Schemas\SifarnikSrednjeSkoleForm;
use App\Filament\Resources\SifarnikSrednjeSkole\Tables\SifarnikSrednjeSkoleTable;
use App\Models\SifarnikSrednjeSkole as SifarnikSrednjeSkoleModel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class SifarnikSrednjeSkoleResource extends Resource
{
    protected static ?string $model = SifarnikSrednjeSkoleModel::class;

    protected static ?string $slug = 'high-schools';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Средње школе';

    protected static ?string $modelLabel = 'Средња школа';

    protected static ?string $pluralModelLabel = 'Средње школе';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:SifarnikSrednjeSkole'));
    }

    public static function form(Schema $schema): Schema
    {
        return SifarnikSrednjeSkoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SifarnikSrednjeSkoleTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListSifarnikSrednjeSkole::route('/'),
            'create' => CreateSifarnikSrednjeSkole::route('/create'),
            'edit'   => EditSifarnikSrednjeSkole::route('/{record}/edit'),
        ];
    }
}
