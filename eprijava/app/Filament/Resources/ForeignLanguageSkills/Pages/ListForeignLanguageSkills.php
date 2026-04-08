<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguageSkillSet;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListForeignLanguageSkills extends ListRecords
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    public function mount(): void
    {
        if (!Auth::user()->hasRole('super_admin')) {
            $set = ForeignLanguageSkillSet::where('user_id', Auth::id())->first();
            if (!$set) {
                $set = ForeignLanguageSkillSet::create(['user_id' => Auth::id()]);
            }
            $this->redirect(ForeignLanguageSkillResource::getUrl('edit', ['record' => $set->id]));
            return;
        }

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}