<?php

namespace App\Filament\Resources\AdditionalTrainings;

use App\Filament\Resources\AdditionalTrainings\Pages\CreateAdditionalTraining;
use App\Filament\Resources\AdditionalTrainings\Pages\EditAdditionalTraining;
use App\Filament\Resources\AdditionalTrainings\Pages\ListAdditionalTrainings;
use App\Filament\Resources\AdditionalTrainings\Schemas\AdditionalTrainingForm;
use App\Filament\Resources\AdditionalTrainings\Tables\AdditionalTrainingsTable;
use App\Models\AdditionalTraining;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class AdditionalTrainingResource extends Resource
{
    protected static ?string $model = AdditionalTraining::class;

    protected static ?string $slug = 'additional-trainings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static string|UnitEnum|null $navigationGroup = 'Мој профил';

    protected static ?string $navigationLabel = 'Додатне обуке';

    protected static ?string $modelLabel = 'Додатна обука';

    protected static ?string $pluralModelLabel = 'Додатне обуке';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return AdditionalTrainingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AdditionalTrainingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListAdditionalTrainings::route('/'),
            'create' => CreateAdditionalTraining::route('/create'),
            'edit'   => EditAdditionalTraining::route('/{record}/edit'),
        ];
    }
}
