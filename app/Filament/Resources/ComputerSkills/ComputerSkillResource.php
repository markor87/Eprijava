<?php

namespace App\Filament\Resources\ComputerSkills;

use App\Filament\Resources\ComputerSkills\Pages\CreateComputerSkill;
use App\Filament\Resources\ComputerSkills\Pages\EditComputerSkill;
use App\Filament\Resources\ComputerSkills\Pages\ListComputerSkills;
use App\Filament\Resources\ComputerSkills\Schemas\ComputerSkillForm;
use App\Filament\Resources\ComputerSkills\Tables\ComputerSkillsTable;
use App\Models\ComputerSkill;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComputerSkillResource extends Resource
{
    protected static ?string $model = ComputerSkill::class;

    protected static ?string $slug = 'computer-skills';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedComputerDesktop;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Рад на рачунару';

    protected static ?string $modelLabel = 'Рад на рачунару';

    protected static ?string $pluralModelLabel = 'Рад на рачунару';

    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return ComputerSkillForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComputerSkillsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:ComputerSkill'));
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
            'index'  => ListComputerSkills::route('/'),
            'create' => CreateComputerSkill::route('/create'),
            'edit'   => EditComputerSkill::route('/{record}/edit'),
        ];
    }
}
