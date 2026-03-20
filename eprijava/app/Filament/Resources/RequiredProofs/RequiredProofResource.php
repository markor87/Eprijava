<?php

namespace App\Filament\Resources\RequiredProofs;

use App\Filament\Resources\RequiredProofs\Pages\CreateRequiredProof;
use App\Filament\Resources\RequiredProofs\Pages\EditRequiredProof;
use App\Filament\Resources\RequiredProofs\Pages\ListRequiredProofs;
use App\Filament\Resources\RequiredProofs\Schemas\RequiredProofForm;
use App\Filament\Resources\RequiredProofs\Tables\RequiredProofsTable;
use App\Models\RequiredProof;
use BackedEnum;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class RequiredProofResource extends Resource
{
    protected static ?string $model = RequiredProof::class;

    protected static ?string $slug = 'required-proofs';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static string|UnitEnum|null $navigationGroup = 'Администрација';

    protected static ?string $navigationLabel = 'Докази уз пријаву';

    protected static ?string $modelLabel = 'Доказ';

    protected static ?string $pluralModelLabel = 'Докази уз пријаву';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return RequiredProofForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RequiredProofsTable::configure($table);
    }

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->canAny([
            'ViewAny:RequiredProof',
            'View:RequiredProof',
            'Create:RequiredProof',
            'Update:RequiredProof',
            'Delete:RequiredProof',
        ]));
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListRequiredProofs::route('/'),
            'create' => CreateRequiredProof::route('/create'),
            'edit'   => EditRequiredProof::route('/{record}/edit'),
        ];
    }
}
