<?php

namespace App\Filament\Resources\NationalMinorities\Pages;

use App\Filament\Resources\NationalMinorities\NationalMinorityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateNationalMinority extends CreateRecord
{
    protected static string $resource = NationalMinorityResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
