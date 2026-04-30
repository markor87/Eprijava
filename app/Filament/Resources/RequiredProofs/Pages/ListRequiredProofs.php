<?php

namespace App\Filament\Resources\RequiredProofs\Pages;

use App\Filament\Resources\RequiredProofs\RequiredProofResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRequiredProofs extends ListRecords
{
    protected static string $resource = RequiredProofResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај доказ'),
        ];
    }
}
