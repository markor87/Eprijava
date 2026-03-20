<?php

namespace App\Filament\Resources\VacancySources\Pages;

use App\Filament\Resources\VacancySources\VacancySourceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVacancySources extends ListRecords
{
    protected static string $resource = VacancySourceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај одговоре'),
        ];
    }
}
