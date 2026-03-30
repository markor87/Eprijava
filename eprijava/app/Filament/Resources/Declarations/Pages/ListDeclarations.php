<?php

namespace App\Filament\Resources\Declarations\Pages;

use App\Filament\Resources\Declarations\DeclarationResource;
use App\Models\Declaration;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeclarations extends ListRecords
{
    protected static string $resource = DeclarationResource::class;

    protected function getHeaderActions(): array
    {
        $hasRecord = Declaration::where('user_id', auth()->id())->exists();

        return $hasRecord ? [] : [
            CreateAction::make()->label('Додај изјаве'),
        ];
    }
}
