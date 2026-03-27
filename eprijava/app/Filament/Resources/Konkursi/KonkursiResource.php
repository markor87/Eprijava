<?php

namespace App\Filament\Resources\Konkursi;

use App\Filament\Resources\Konkursi\Pages\CreateKonkurs;
use App\Filament\Resources\Konkursi\Pages\EditKonkurs;
use App\Filament\Resources\Konkursi\Pages\ListKonkursi;
use App\Filament\Resources\Konkursi\Schemas\KonkursForm;
use App\Filament\Resources\Konkursi\Tables\KonkursiTable;
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

class KonkursiResource extends Resource
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
        return KonkursForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KonkursiTable::configure($table);
    }

    public static function canAccess(): bool
    {
        /** @var User|null $user */
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:Competition',
            'View:Competition',
            'Create:Competition',
            'Update:Competition',
            'Delete:Competition',
        ]));
    }

    public static function getEloquentQuery(): Builder
    {
        /** @var User|null $user */
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && ($user->hasRole('super_admin') || $user->can('ViewAny:Competition'))) {
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
            'index'  => ListKonkursi::route('/'),
            'create' => CreateKonkurs::route('/create'),
            'edit'   => EditKonkurs::route('/{record}/edit'),
        ];
    }
}
