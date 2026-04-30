<?php

namespace App\Filament\Resources\VacancySources;

use App\Filament\Resources\VacancySources\Pages\CreateVacancySource;
use App\Filament\Resources\VacancySources\Pages\EditVacancySource;
use App\Filament\Resources\VacancySources\Pages\ListVacancySources;
use App\Filament\Resources\VacancySources\Schemas\VacancySourceForm;
use App\Filament\Resources\VacancySources\Tables\VacancySourcesTable;
use App\Models\VacancySource;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class VacancySourceResource extends Resource
{
    protected static ?string $model = VacancySource::class;

    protected static ?string $slug = 'vacancy-sources';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMagnifyingGlass;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Сазнавање о конкурсу';

    protected static ?string $modelLabel = 'Сазнавање о конкурсу';

    protected static ?string $pluralModelLabel = 'Сазнавање о конкурсу';

    protected static ?int $navigationSort = 9;

    public static function form(Schema $schema): Schema
    {
        return VacancySourceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VacancySourcesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:VacancySource'));
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
            'index'  => ListVacancySources::route('/'),
            'create' => CreateVacancySource::route('/create'),
            'edit'   => EditVacancySource::route('/{record}/edit'),
        ];
    }
}
