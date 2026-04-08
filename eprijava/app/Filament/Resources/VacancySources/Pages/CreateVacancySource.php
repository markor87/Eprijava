<?php

namespace App\Filament\Resources\VacancySources\Pages;

use App\Filament\Resources\VacancySources\VacancySourceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVacancySource extends CreateRecord
{
    protected static string $resource = VacancySourceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
