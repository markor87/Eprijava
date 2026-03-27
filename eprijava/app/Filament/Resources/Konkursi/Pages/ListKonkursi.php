<?php

namespace App\Filament\Resources\Konkursi\Pages;

use App\Filament\Resources\Konkursi\KonkursiResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKonkursi extends ListRecords
{
    protected static string $resource = KonkursiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај конкурс'),
        ];
    }
}
