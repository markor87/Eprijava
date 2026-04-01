<?php

namespace App\Filament\Resources\Competitions;

use App\Filament\Resources\Competitions\Pages\CreateCompetition;
use App\Filament\Resources\Competitions\Pages\EditCompetition;
use App\Filament\Resources\Competitions\Pages\ListCompetitions;
use App\Filament\Resources\Competitions\Schemas\CompetitionForm;
use App\Filament\Resources\Competitions\Tables\CompetitionsTable;
use App\Models\Competition;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CompetitionsResource extends Resource
{
    protected static ?string $model = Competition::class;

    protected static ?string $slug = 'competitions';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Конкурси';

    protected static ?string $navigationLabel = 'Конкурси';

    protected static ?string $modelLabel = 'Конкурс';

    protected static ?string $pluralModelLabel = 'Конкурси';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return CompetitionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CompetitionsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:Competition'));
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User|null $user */
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && $user->hasRole('super_admin')) {
            return $query;
        }

        return $query->where('user_id', $user?->id);
    }

    public static function canCreate(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('Create:Competition'));
    }

    public static function canEdit(Model $record): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || (
            $user->can('Update:Competition') && $record->government_body_id === $user->government_body_id
        ));
    }

    public static function canDelete(Model $record): bool
    {
        if ($record->jobPositions()->exists()) {
            return false;
        }

        /** @var User|null $user */
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || (
            $user->can('Delete:Competition') && $record->government_body_id === $user->government_body_id
        ));
    }

    public static function can(string|\UnitEnum $action, Model|null $record = null): bool
    {
        return match ($action) {
            'create'         => static::canCreate(),
            'update', 'edit' => $record !== null ? static::canEdit($record) : false,
            'delete'         => $record !== null ? static::canDelete($record) : false,
            default          => parent::can($action, $record),
        };
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListCompetitions::route('/'),
            'create' => CreateCompetition::route('/create'),
            'edit'   => EditCompetition::route('/{record}/edit'),
        ];
    }
}
