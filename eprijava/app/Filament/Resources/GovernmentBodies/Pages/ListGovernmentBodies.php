<?php

namespace App\Filament\Resources\GovernmentBodies\Pages;

use App\Filament\Resources\GovernmentBodies\GovernmentBodyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGovernmentBodies extends ListRecords
{
    protected static string $resource = GovernmentBodyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај орган'),
        ];
    }
}
