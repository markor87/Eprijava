<?php

namespace App\Filament\Resources\WorkExperiences;

use App\Filament\Resources\WorkExperiences\Pages\CreateWorkExperience;
use App\Filament\Resources\WorkExperiences\Pages\EditWorkExperience;
use App\Filament\Resources\WorkExperiences\Pages\ListWorkExperiences;
use App\Filament\Resources\WorkExperiences\Schemas\WorkExperienceForm;
use App\Filament\Resources\WorkExperiences\Tables\WorkExperiencesTable;
use App\Models\WorkExperience;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class WorkExperienceResource extends Resource
{
    protected static ?string $model = WorkExperience::class;

    protected static ?string $slug = 'work-experiences';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Радно искуство';

    protected static ?string $modelLabel = 'Радно искуство';

    protected static ?string $pluralModelLabel = 'Радно искуство';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return WorkExperienceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WorkExperiencesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:WorkExperience',
            'View:WorkExperience',
            'Create:WorkExperience',
            'Update:WorkExperience',
            'Delete:WorkExperience',
        ]));
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && ($user->hasRole('super_admin') || $user->can('ViewAny:WorkExperience'))) {
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
            'index'  => ListWorkExperiences::route('/'),
            'create' => CreateWorkExperience::route('/create'),
            'edit'   => EditWorkExperience::route('/{record}/edit'),
        ];
    }
}
