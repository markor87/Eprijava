<?php

namespace App\Filament\Resources\Declarations\Pages;

use App\Filament\Resources\Declarations\DeclarationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDeclaration extends CreateRecord
{
    protected static string $resource = DeclarationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
