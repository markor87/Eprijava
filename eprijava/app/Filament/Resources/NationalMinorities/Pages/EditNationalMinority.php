<?php

namespace App\Filament\Resources\NationalMinorities\Pages;

use App\Filament\Resources\NationalMinorities\NationalMinorityResource;
use Filament\Resources\Pages\EditRecord;

class EditNationalMinority extends EditRecord
{
    protected static string $resource = NationalMinorityResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
