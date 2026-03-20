<?php

namespace App\Filament\Resources\Declarations;

use App\Filament\Resources\Declarations\Pages\CreateDeclaration;
use App\Filament\Resources\Declarations\Pages\EditDeclaration;
use App\Filament\Resources\Declarations\Pages\ListDeclarations;
use App\Filament\Resources\Declarations\Schemas\DeclarationForm;
use App\Filament\Resources\Declarations\Tables\DeclarationsTable;
use App\Models\Declaration;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DeclarationResource extends Resource
{
    protected static ?string $model = Declaration::class;

    protected static ?string $slug = 'declarations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Изјаве';

    protected static ?string $modelLabel = 'Изјава';

    protected static ?string $pluralModelLabel = 'Изјаве';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return DeclarationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DeclarationsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:Declaration',
            'View:Declaration',
            'Create:Declaration',
            'Update:Declaration',
            'Delete:Declaration',
        ]));
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $query = parent::getEloquentQuery();

        if ($user && ($user->hasRole('super_admin') || $user->can('ViewAny:Declaration'))) {
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
            'index'  => ListDeclarations::route('/'),
            'create' => CreateDeclaration::route('/create'),
            'edit'   => EditDeclaration::route('/{record}/edit'),
        ];
    }
}
