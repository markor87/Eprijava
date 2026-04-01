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
        ForeignLanguageSkillSet::firstOrCreate(['user_id' => Auth::id()]);

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if (!$user?->hasRole('super_admin') && !$user?->can('Create:ForeignLanguageSkillSet')) {
            return [];
        }

        $set = ForeignLanguageSkillSet::firstOrCreate(['user_id' => Auth::id()]);

        return [
            Action::make('edit_my_skills')
                ->label('Додај страни језик')
                ->url(ForeignLanguageSkillResource::getUrl('edit', ['record' => $set->id])),
        ];
    }
}