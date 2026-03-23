<?php

namespace App\Filament\Resources\ForeignLanguages;

use App\Filament\Resources\ForeignLanguages\Pages\CreateForeignLanguage;
use App\Filament\Resources\ForeignLanguages\Pages\EditForeignLanguage;
use App\Filament\Resources\ForeignLanguages\Pages\ListForeignLanguages;
use App\Filament\Resources\ForeignLanguages\Schemas\ForeignLanguageForm;
use App\Filament\Resources\ForeignLanguages\Tables\ForeignLanguagesTable;
use App\Models\ForeignLanguage;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ForeignLanguageResource extends Resource
{
    protected static ?string $model = ForeignLanguage::class;

    protected static ?string $slug = 'foreign-languages';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedLanguage;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Страни језици';

    protected static ?string $modelLabel = 'Страни језик';

    protected static ?string $pluralModelLabel = 'Страни језици';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ForeignLanguageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ForeignLanguagesTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:ForeignLanguage',
            'View:ForeignLanguage',
            'Create:ForeignLanguage',
            'Update:ForeignLanguage',
            'Delete:ForeignLanguage',
        ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListForeignLanguages::route('/'),
            'create' => CreateForeignLanguage::route('/create'),
            'edit'   => EditForeignLanguage::route('/{record}/edit'),
        ];
    }
}
