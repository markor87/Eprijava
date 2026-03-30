<?php

namespace App\Filament\Resources\HighSchoolEducations\Pages;

use App\Filament\Resources\HighSchoolEducations\HighSchoolEducationResource;
use App\Models\HighSchoolEducation;
use Filament\Resources\Pages\CreateRecord;

class CreateHighSchoolEducation extends CreateRecord
{
    protected static string $resource = HighSchoolEducationResource::class;

    public function mount(): void
    {
        $existing = HighSchoolEducation::where('user_id', auth()->id())->first();

        if ($existing) {
            $this->redirect(HighSchoolEducationResource::getUrl('edit', ['record' => $existing]));
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
