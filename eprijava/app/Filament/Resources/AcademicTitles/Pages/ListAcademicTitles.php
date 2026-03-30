<?php

namespace App\Filament\Resources\AcademicTitles\Pages;

use App\Filament\Resources\AcademicTitles\AcademicTitleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAcademicTitles extends ListRecords
{
    protected static string $resource = AcademicTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај звање'),
        ];
    }
}
