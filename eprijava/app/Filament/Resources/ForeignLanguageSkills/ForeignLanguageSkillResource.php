<?php

namespace App\Filament\Resources\ForeignLanguageSkills;

use App\Filament\Resources\ForeignLanguageSkills\Pages\EditForeignLanguageSkill;
use App\Filament\Resources\ForeignLanguageSkills\Pages\ListForeignLanguageSkills;
use App\Filament\Resources\ForeignLanguageSkills\Schemas\ForeignLanguageSkillForm;
use App\Filament\Resources\ForeignLanguageSkills\Tables\ForeignLanguageSkillsTable;
use App\Models\ForeignLanguage;
use App\Models\ForeignLanguageSkillSet;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ForeignLanguageSkillResource extends Resource
{
    protected static ?string $model = ForeignLanguageSkillSet::class;

    protected static ?string $slug = 'foreign-language-skills';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Страни језици';

    protected static ?string $modelLabel = 'Страни језик';

    protected static ?string $pluralModelLabel = 'Страни језици';

    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return ForeignLanguageSkillForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ForeignLanguageSkillsTable::configure($table);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return parent::shouldRegisterNavigation() && ForeignLanguage::exists();
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user
            && ($user->hasRole('super_admin') || $user->can('ViewAny:ForeignLanguageSkillSet'))
            && ForeignLanguage::exists();
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
            'index' => ListForeignLanguageSkills::route('/'),
            'edit'  => EditForeignLanguageSkill::route('/{record}/edit'),
        ];
    }
}
