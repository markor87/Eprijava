<?php

namespace App\Filament\Resources\AcademicTitles\Pages;

use App\Filament\Resources\AcademicTitles\AcademicTitleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAcademicTitle extends EditRecord
{
    protected static string $resource = AcademicTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
