<?php

namespace App\Filament\Resources\Candidates\Pages;

use App\Filament\Resources\Candidates\CandidateResource;
use App\Models\Candidate;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCandidates extends ListRecords
{
    protected static string $resource = CandidateResource::class;

    protected function getHeaderActions(): array
    {
        $hasRecord = Candidate::where('user_id', auth()->id())->exists();

        return $hasRecord ? [] : [
            CreateAction::make()->label('Додај личне податке'),
        ];
    }
}
