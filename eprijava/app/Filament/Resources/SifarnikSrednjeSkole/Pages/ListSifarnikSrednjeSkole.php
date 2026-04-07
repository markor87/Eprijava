<?php

namespace App\Filament\Resources\SifarnikSrednjeSkole\Pages;

use App\Filament\Resources\SifarnikSrednjeSkole\SifarnikSrednjeSkoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSifarnikSrednjeSkole extends ListRecords
{
    protected static string $resource = SifarnikSrednjeSkoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Додај школу'),
        ];
    }
}
