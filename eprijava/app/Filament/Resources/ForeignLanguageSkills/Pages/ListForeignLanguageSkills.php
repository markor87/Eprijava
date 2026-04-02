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
        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        $user = Auth::user();

        if (!$user?->hasRole('super_admin') && !$user?->can('Create:ForeignLanguageSkillSet')) {
            return [];
        }

        $set = ForeignLanguageSkillSet::where('user_id', Auth::id())->first();

        if ($set) {
            return [
                Action::make('edit_my_skills')
                    ->label('Додај страни језик')
                    ->url(ForeignLanguageSkillResource::getUrl('edit', ['record' => $set->id])),
            ];
        }

        return [
            Action::make('edit_my_skills')
                ->label('Додај страни језик')
                ->action(function () {
                    $set = ForeignLanguageSkillSet::create(['user_id' => Auth::id()]);
                    $this->redirect(ForeignLanguageSkillResource::getUrl('edit', ['record' => $set->id]));
                }),
        ];
    }
}