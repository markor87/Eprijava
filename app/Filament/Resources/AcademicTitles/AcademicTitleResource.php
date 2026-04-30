<?php

namespace App\Filament\Resources\AcademicTitles;

use App\Filament\Resources\AcademicTitles\Pages\CreateAcademicTitle;
use App\Filament\Resources\AcademicTitles\Pages\EditAcademicTitle;
use App\Filament\Resources\AcademicTitles\Pages\ListAcademicTitles;
use App\Filament\Resources\AcademicTitles\Schemas\AcademicTitleForm;
use App\Filament\Resources\AcademicTitles\Tables\AcademicTitlesTable;
use App\Models\AcademicTitle;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class AcademicTitleResource extends Resource
{
    protected static ?string $model = AcademicTitle::class;

    protected static ?string $slug = 'academic-titles';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Шифарник поља, области и звања';

    protected static ?string $modelLabel = 'Звање';

    protected static ?string $pluralModelLabel = 'Шифарник поља, области и звања';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:AcademicTitle'));
    }

    public static function form(Schema $schema): Schema
    {
        return AcademicTitleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AcademicTitlesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAcademicTitles::route('/'),
            'create' => CreateAcademicTitle::route('/create'),
            'edit'   => EditAcademicTitle::route('/{record}/edit'),
        ];
    }
}
