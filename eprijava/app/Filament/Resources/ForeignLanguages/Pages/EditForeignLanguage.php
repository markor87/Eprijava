<?php

namespace App\Filament\Resources\ForeignLanguages\Pages;

use App\Filament\Resources\ForeignLanguages\ForeignLanguageResource;
use Filament\Resources\Pages\EditRecord;

class EditForeignLanguage extends EditRecord
{
    protected static string $resource = ForeignLanguageResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
