<?php

namespace App\Filament\Resources\Declarations\Pages;

use App\Filament\Resources\Declarations\DeclarationResource;
use App\Models\Declaration;
use Filament\Resources\Pages\ListRecords;

class ListDeclarations extends ListRecords
{
    protected static string $resource = DeclarationResource::class;

    public function mount(): void
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $existing = Declaration::where('user_id', auth()->id())->first();
            if ($existing) {
                $this->redirect(DeclarationResource::getUrl('edit', ['record' => $existing]));
            } else {
                $this->redirect(DeclarationResource::getUrl('create'));
            }
            return;
        }

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
