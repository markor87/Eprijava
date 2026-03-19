<?php

namespace App\Filament\Resources\HigherEducations;

use App\Filament\Resources\HigherEducations\Pages\CreateHigherEducation;
use App\Filament\Resources\HigherEducations\Pages\EditHigherEducation;
use App\Filament\Resources\HigherEducations\Pages\ListHigherEducations;
use App\Filament\Resources\HigherEducations\Schemas\HigherEducationForm;
use App\Filament\Resources\HigherEducations\Tables\HigherEducationsTable;
use App\Models\HigherEducation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class HigherEducationResource extends Resource
{
    protected static ?string $model = HigherEducation::class;

    protected static ?string $slug = 'higher-educations';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Високо образовање';

    protected static ?string $modelLabel = 'Високо образовање';

    protected static ?string $pluralModelLabel = 'Високо образовање';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return HigherEducationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HigherEducationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListHigherEducations::route('/'),
            'create' => CreateHigherEducation::route('/create'),
            'edit'   => EditHigherEducation::route('/{record}/edit'),
        ];
    }
}
