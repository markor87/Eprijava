<?php

namespace App\Filament\Resources\HighSchoolEducations\Pages;

use App\Filament\Resources\HighSchoolEducations\HighSchoolEducationResource;
use App\Models\HighSchoolEducation;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHighSchoolEducations extends ListRecords
{
    protected static string $resource = HighSchoolEducationResource::class;

    protected function getHeaderActions(): array
    {
        $hasRecord = HighSchoolEducation::where('user_id', auth()->id())->exists();

        return $hasRecord ? [] : [
            CreateAction::make()->label('Додај школу'),
        ];
    }
}
