<?php

namespace App\Filament\Resources\HighSchoolEducations\Pages;

use App\Filament\Resources\HighSchoolEducations\HighSchoolEducationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHighSchoolEducations extends ListRecords
{
    protected static string $resource = HighSchoolEducationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај школу'),
        ];
    }
}
