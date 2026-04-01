<?php

namespace App\Filament\Resources\JobPositions\Pages;

use App\Filament\Resources\JobPositions\JobPositionResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateJobPosition extends CreateRecord
{
    protected static string $resource = JobPositionResource::class;

    public int $competitionId;

    public function mount(): void
    {
        $this->competitionId = (int) request()->query('competition_id');

        if (!$this->competitionId) {
            Notification::make()
                ->title('Није одабран конкурс')
                ->body('Отворите радна места преко странице конкурса.')
                ->warning()
                ->send();

            $this->redirect(JobPositionResource::getUrl('index'));
            return;
        }

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
