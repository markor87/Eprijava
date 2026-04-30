<?php

namespace App\Filament\Resources\Candidates\Pages;

use App\Filament\Resources\Candidates\CandidateResource;
use App\Models\Candidate;
use Filament\Resources\Pages\ListRecords;

class ListCandidates extends ListRecords
{
    protected static string $resource = CandidateResource::class;

    public function mount(): void
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $existing = Candidate::where('user_id', auth()->id())->first();
            if ($existing) {
                $this->redirect(CandidateResource::getUrl('edit', ['record' => $existing]));
            } else {
                $this->redirect(CandidateResource::getUrl('create'));
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
