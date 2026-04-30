<?php

namespace App\Filament\Resources\GovernmentBodies\Pages;

use App\Filament\Resources\GovernmentBodies\GovernmentBodyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGovernmentBody extends EditRecord
{
    protected static string $resource = GovernmentBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
