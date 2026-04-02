<?php

namespace App\Filament\Resources\Candidates\Pages;

use App\Filament\Resources\Candidates\CandidateResource;
use App\Models\Candidate;
use Filament\Resources\Pages\CreateRecord;

class CreateCandidate extends CreateRecord
{
    protected static string $resource = CandidateResource::class;

    public function mount(): void
    {
        $existing = Candidate::where('user_id', auth()->id())->first();

        if ($existing) {
            $this->redirect(CandidateResource::getUrl('edit', ['record' => $existing]));
            return;
        }

        parent::mount();

        $this->form->fill([
            'email' => auth()->user()->email,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();

        return $data;
    }
}
