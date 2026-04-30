<?php

namespace App\Filament\Resources\AcademicTitles\Pages;

use App\Filament\Resources\AcademicTitles\AcademicTitleResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAcademicTitle extends CreateRecord
{
    protected static string $resource = AcademicTitleResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
