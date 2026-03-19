<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForeignLanguageSkills extends ListRecords
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај страни језик'),
        ];
    }
}
