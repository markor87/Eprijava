<?php

namespace App\Filament\Resources\ForeignLanguages\Pages;

use App\Filament\Resources\ForeignLanguages\ForeignLanguageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListForeignLanguages extends ListRecords
{
    protected static string $resource = ForeignLanguageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај страни језик'),
        ];
    }
}
