<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateForeignLanguageSkill extends CreateRecord
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
