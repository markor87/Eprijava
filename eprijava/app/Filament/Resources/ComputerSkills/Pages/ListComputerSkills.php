<?php

namespace App\Filament\Resources\ComputerSkills\Pages;

use App\Filament\Resources\ComputerSkills\ComputerSkillResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListComputerSkills extends ListRecords
{
    protected static string $resource = ComputerSkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај податке о раду на рачунару'),
        ];
    }
}
