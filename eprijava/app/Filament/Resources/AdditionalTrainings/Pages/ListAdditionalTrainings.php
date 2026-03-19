<?php

namespace App\Filament\Resources\AdditionalTrainings\Pages;

use App\Filament\Resources\AdditionalTrainings\AdditionalTrainingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAdditionalTrainings extends ListRecords
{
    protected static string $resource = AdditionalTrainingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај додатну обуку'),
        ];
    }
}
