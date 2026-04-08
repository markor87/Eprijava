<?php

namespace App\Filament\Resources\HighSchoolEducations\Pages;

use App\Filament\Resources\HighSchoolEducations\HighSchoolEducationResource;
use App\Models\HighSchoolEducation;
use Filament\Resources\Pages\ListRecords;

class ListHighSchoolEducations extends ListRecords
{
    protected static string $resource = HighSchoolEducationResource::class;

    public function mount(): void
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $existing = HighSchoolEducation::where('user_id', auth()->id())->first();
            if ($existing) {
                $this->redirect(HighSchoolEducationResource::getUrl('edit', ['record' => $existing]));
            } else {
                $this->redirect(HighSchoolEducationResource::getUrl('create'));
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
