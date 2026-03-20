<?php

namespace App\Filament\Resources\Trainings;

use App\Filament\Resources\Trainings\Pages\CreateTraining;
use App\Filament\Resources\Trainings\Pages\EditTraining;
use App\Filament\Resources\Trainings\Pages\ListTrainings;
use App\Filament\Resources\Trainings\Schemas\TrainingForm;
use App\Filament\Resources\Trainings\Tables\TrainingsTable;
use App\Models\Training;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TrainingResource extends Resource
{
    protected static ?string $model = Training::class;

    protected static ?string $slug = 'trainings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Стручни и други испити';

    protected static ?string $modelLabel = 'Испит';

    protected static ?string $pluralModelLabel = 'Стручни и други испити';

    protected static ?int $navigationSort = 5;

    public static function form(Schema $schema): Schema
    {
        return TrainingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TrainingsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:Training',
            'View:Training',
            'Create:Training',
            'Update:Training',
            'Delete:Training',
        ]));
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && ($user->hasRole('super_admin') || $user->can('ViewAny:Training'))) {
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
            'index'  => ListTrainings::route('/'),
            'create' => CreateTraining::route('/create'),
            'edit'   => EditTraining::route('/{record}/edit'),
        ];
    }
}
