<?php

namespace App\Filament\Resources\HighSchools\Pages;

use App\Filament\Resources\HighSchools\HighSchoolResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHighSchool extends EditRecord
{
    protected static string $resource = HighSchoolResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
