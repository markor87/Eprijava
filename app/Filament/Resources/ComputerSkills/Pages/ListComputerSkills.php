<?php

namespace App\Filament\Resources\ComputerSkills\Pages;

use App\Filament\Resources\ComputerSkills\ComputerSkillResource;
use App\Models\ComputerSkill;
use Filament\Resources\Pages\ListRecords;

class ListComputerSkills extends ListRecords
{
    protected static string $resource = ComputerSkillResource::class;

    public function mount(): void
    {
        if (!auth()->user()->hasRole('super_admin')) {
            $existing = ComputerSkill::where('user_id', auth()->id())->first();
            if ($existing) {
                $this->redirect(ComputerSkillResource::getUrl('edit', ['record' => $existing]));
            } else {
                $this->redirect(ComputerSkillResource::getUrl('create'));
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
