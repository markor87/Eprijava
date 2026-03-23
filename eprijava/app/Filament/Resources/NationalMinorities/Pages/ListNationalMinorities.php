<?php

namespace App\Filament\Resources\NationalMinorities\Pages;

use App\Filament\Resources\NationalMinorities\NationalMinorityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNationalMinorities extends ListRecords
{
    protected static string $resource = NationalMinorityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
