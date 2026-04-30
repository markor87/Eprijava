<?php

namespace App\Filament\Resources\AdditionalTrainings\Pages;

use App\Filament\Resources\AdditionalTrainings\AdditionalTrainingResource;
use Filament\Resources\Pages\EditRecord;

class EditAdditionalTraining extends EditRecord
{
    protected static string $resource = AdditionalTrainingResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
