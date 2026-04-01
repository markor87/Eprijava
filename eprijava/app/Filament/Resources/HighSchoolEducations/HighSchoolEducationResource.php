<?php

namespace App\Filament\Resources\HighSchoolEducations;

use App\Filament\Resources\HighSchoolEducations\Pages\CreateHighSchoolEducation;
use App\Filament\Resources\HighSchoolEducations\Pages\EditHighSchoolEducation;
use App\Filament\Resources\HighSchoolEducations\Pages\ListHighSchoolEducations;
use App\Filament\Resources\HighSchoolEducations\Schemas\HighSchoolEducationForm;
use App\Filament\Resources\HighSchoolEducations\Tables\HighSchoolEducationsTable;
use App\Models\HighSchoolEducation;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HighSchoolEducationResource extends Resource
{
    protected static ?string $model = HighSchoolEducation::class;

    protected static ?string $slug = 'high-school-educations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Средња школа';

    protected static ?string $modelLabel = 'Средња школа';

    protected static ?string $pluralModelLabel = 'Средња школа';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return HighSchoolEducationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HighSchoolEducationsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:HighSchoolEducation'));
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && $user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('user_id', $user?->id);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHighSchoolEducations::route('/'),
            'create' => CreateHighSchoolEducation::route('/create'),
            'edit'   => EditHighSchoolEducation::route('/{record}/edit'),
        ];
    }
}
