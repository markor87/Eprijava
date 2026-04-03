<?php

namespace App\Filament\Resources\ComputerSkills\Pages;

use App\Filament\Resources\ComputerSkills\ComputerSkillResource;
use Filament\Resources\Pages\EditRecord;

class EditComputerSkill extends EditRecord
{
    protected static string $resource = ComputerSkillResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
