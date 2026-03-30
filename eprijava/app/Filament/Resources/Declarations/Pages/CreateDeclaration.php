<?php

namespace App\Filament\Resources\Declarations\Pages;

use App\Filament\Resources\Declarations\DeclarationResource;
use App\Models\Declaration;
use Filament\Resources\Pages\CreateRecord;

class CreateDeclaration extends CreateRecord
{
    protected static string $resource = DeclarationResource::class;

    public function mount(): void
    {
        $existing = Declaration::where('user_id', auth()->id())->first();

        if ($existing) {
            $this->redirect(DeclarationResource::getUrl('edit', ['record' => $existing]));
            return;
        }

        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
