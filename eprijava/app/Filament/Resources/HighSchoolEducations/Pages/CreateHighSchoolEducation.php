<?php

namespace App\Filament\Resources\HighSchoolEducations\Pages;

use App\Filament\Resources\HighSchoolEducations\HighSchoolEducationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHighSchoolEducation extends CreateRecord
{
    protected static string $resource = HighSchoolEducationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
