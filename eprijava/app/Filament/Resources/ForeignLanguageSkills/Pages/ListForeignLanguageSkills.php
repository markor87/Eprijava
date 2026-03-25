<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguageSkillSet;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListForeignLanguageSkills extends ListRecords
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    public function mount(): void
    {
        $set = ForeignLanguageSkillSet::firstOrCreate(['user_id' => auth()->user()?->id]);

        parent::mount();
    }

    protected function getHeaderActions(): array
    {
        $set = ForeignLanguageSkillSet::firstOrCreate(['user_id' => auth()->user()?->id]);

        return [
            Action::make('edit_my_skills')
                ->label('Додај страни језик')
                ->url(ForeignLanguageSkillResource::getUrl('edit', ['record' => $set->id])),
        ];
    }
}
