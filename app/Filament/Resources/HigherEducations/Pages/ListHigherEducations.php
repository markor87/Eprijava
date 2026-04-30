<?php

namespace App\Filament\Resources\HigherEducations\Pages;

use App\Filament\Resources\HigherEducations\HigherEducationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHigherEducations extends ListRecords
{
    protected static string $resource = HigherEducationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај факултет / установу'),
        ];
    }
}
