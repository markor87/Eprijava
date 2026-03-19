<?php

namespace App\Filament\Resources\HigherEducations\Pages;

use App\Filament\Resources\HigherEducations\HigherEducationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHigherEducation extends CreateRecord
{
    protected static string $resource = HigherEducationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
