<?php

namespace App\Filament\Resources\ComputerSkills\Pages;

use App\Filament\Resources\ComputerSkills\ComputerSkillResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComputerSkill extends CreateRecord
{
    protected static string $resource = ComputerSkillResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
