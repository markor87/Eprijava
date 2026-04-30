<?php

namespace App\Filament\Resources\AdditionalTrainings\Pages;

use App\Filament\Resources\AdditionalTrainings\AdditionalTrainingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAdditionalTraining extends CreateRecord
{
    protected static string $resource = AdditionalTrainingResource::class;

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
