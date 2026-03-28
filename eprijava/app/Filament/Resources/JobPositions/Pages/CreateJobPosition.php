<?php

namespace App\Filament\Resources\JobPositions\Pages;

use App\Filament\Resources\JobPositions\JobPositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;

    public int $competitionId;

    public function mount(): void
    {
        $this->competitionId = (int) request()->query('competition_id');
        parent::mount();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['competition_id'] = $this->competitionId;
        $data['government_body_id'] = auth()->user()->government_body_id;

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return JobPositionResource::getUrl('index') . '?competition_id=' . $this->competitionId;
    }
}
