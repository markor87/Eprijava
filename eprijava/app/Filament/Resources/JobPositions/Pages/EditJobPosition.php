<?php

namespace App\Filament\Resources\JobPositions\Pages;

use App\Filament\Resources\JobPositions\JobPositionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJobPosition extends EditRecord
{
    protected static string $resource = JobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return JobPositionResource::getUrl('index') . '?competition_id=' . $this->record->competition_id;
    }
}
