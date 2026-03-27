<?php

namespace App\Filament\Resources\Konkursi\Pages;

use App\Filament\Resources\Konkursi\KonkursiResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKonkurs extends EditRecord
{
    protected static string $resource = KonkursiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
