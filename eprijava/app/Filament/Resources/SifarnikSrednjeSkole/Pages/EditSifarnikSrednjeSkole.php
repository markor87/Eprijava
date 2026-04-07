<?php

namespace App\Filament\Resources\SifarnikSrednjeSkole\Pages;

use App\Filament\Resources\SifarnikSrednjeSkole\SifarnikSrednjeSkoleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSifarnikSrednjeSkole extends EditRecord
{
    protected static string $resource = SifarnikSrednjeSkoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
