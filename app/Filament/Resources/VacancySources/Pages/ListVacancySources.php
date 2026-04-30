<?php

namespace App\Filament\Resources\VacancySources\Pages;

use App\Filament\Resources\VacancySources\VacancySourceResource;
use App\Models\VacancySource;
use Filament\Resources\Pages\ListRecords;

class ListVacancySources extends ListRecords
{
    protected static string $resource = VacancySourceResource::class;

    public function mount(): void
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $existing = VacancySource::where('user_id', auth()->id())->first();
            if ($existing) {
                $this->redirect(VacancySourceResource::getUrl('edit', ['record' => $existing]));
            } else {
                $this->redirect(VacancySourceResource::getUrl('create'));
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
