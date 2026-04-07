<?php

namespace App\Filament\Resources\HighSchools;

use App\Filament\Resources\HighSchools\Pages\CreateHighSchool;
use App\Filament\Resources\HighSchools\Pages\EditHighSchool;
use App\Filament\Resources\HighSchools\Pages\ListHighSchools;
use App\Filament\Resources\HighSchools\Schemas\HighSchoolForm;
use App\Filament\Resources\HighSchools\Tables\HighSchoolsTable;
use App\Models\HighSchool;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class HighSchoolResource extends Resource
{
    protected static ?string $model = HighSchool::class;

    protected static ?string $slug = 'high-schools';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Средње школе';

    protected static ?string $modelLabel = 'Средња школа';

    protected static ?string $pluralModelLabel = 'Средње школе';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:HighSchool'));
    }

    public static function form(Schema $schema): Schema
    {
        return HighSchoolForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HighSchoolsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHighSchools::route('/'),
            'create' => CreateHighSchool::route('/create'),
            'edit'   => EditHighSchool::route('/{record}/edit'),
        ];
    }
}
