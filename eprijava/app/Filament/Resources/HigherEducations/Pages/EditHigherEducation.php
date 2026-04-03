<?php

namespace App\Filament\Resources\HigherEducations\Pages;

use App\Filament\Resources\HigherEducations\HigherEducationResource;
use Filament\Resources\Pages\EditRecord;

class EditHigherEducation extends EditRecord
{
    protected static string $resource = HigherEducationResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
