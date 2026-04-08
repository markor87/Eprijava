<?php

namespace App\Filament\Resources\Applications\Pages;

use App\Filament\Resources\Applications\ApplicationResource;
use App\Models\Application;
use App\Models\JobPosition;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateApplication extends CreateRecord
{
    protected static string $resource = ApplicationResource::class;

    public function mount(): void
    {
        $jobPositionId = request()->query('job_position_id');

        $existing = Application::where('user_id', auth()->id())
            ->where('job_position_id', $jobPositionId)
            ->first();

        if ($existing) {
            $this->redirect(ApplicationResource::getUrl('edit', ['record' => $existing]));
            return;
        }

        $user = Auth::user();
        $candidate = $user->candidate;
        $jobPosition = JobPosition::with('rank')->find($jobPositionId);

        parent::mount();

        $this->form->fill([
            'job_position_id'    => $jobPositionId,
            'competition_id'     => $jobPosition?->competition_id,
            'government_body_id' => $jobPosition?->government_body_id,
            'first_name'         => $candidate?->first_name,
            'last_name'          => $candidate?->last_name,
            'national_id'        => $candidate?->national_id,
            'org_unit_path'      => $jobPosition?->org_unit_path,
            'rank_name'          => $jobPosition?->rank?->name,
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id']          = auth()->id();
        $data['profile_snapshot'] = Application::buildProfileSnapshot(Auth::user());
        return $data;
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }
}
