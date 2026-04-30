<?php

namespace App\Filament\Resources\HighSchools\Pages;

use App\Filament\Resources\HighSchools\HighSchoolResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHighSchools extends ListRecords
{
    protected static string $resource = HighSchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај школу'),
        ];
    }
}
