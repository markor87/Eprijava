<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguageSkillSet;
use Filament\Resources\Pages\ListRecords;

class ListForeignLanguageSkills extends ListRecords
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    public function mount(): void
    {
        ForeignLanguageSkillSet::firstOrCreate(['user_id' => auth()->user()?->id]);

        parent::mount();
    }
}
