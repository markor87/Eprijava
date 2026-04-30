<?php

namespace App\Filament\Resources\RequiredProofs\Pages;

use App\Filament\Resources\RequiredProofs\RequiredProofResource;
use Filament\Resources\Pages\EditRecord;

class EditRequiredProof extends EditRecord
{
    protected static string $resource = RequiredProofResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
