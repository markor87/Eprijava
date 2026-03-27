<?php

namespace App\Filament\Resources\Konkursi\Pages;

use App\Filament\Resources\Konkursi\KonkursiResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKonkurs extends CreateRecord
{
    protected static string $resource = KonkursiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $data['government_body_id'] = auth()->user()->government_body_id;

        return $data;
    }
}
