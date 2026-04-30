<?php

namespace App\Filament\Resources\VacancySources\Pages;

use App\Filament\Resources\VacancySources\VacancySourceResource;
use Filament\Resources\Pages\EditRecord;

class EditVacancySource extends EditRecord
{
    protected static string $resource = VacancySourceResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
