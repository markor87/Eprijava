<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguage;
use Filament\Resources\Pages\EditRecord;

class EditForeignLanguageSkill extends EditRecord
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $allLanguageIds = ForeignLanguage::pluck('id');
        $existingIds = $this->record->foreignLanguageSkills()->pluck('foreign_language_id');

        $allLanguageIds->diff($existingIds)->each(function ($languageId) {
            $this->record->foreignLanguageSkills()->create([
                'foreign_language_id' => $languageId,
            ]);
        });

        return $data;
    }
}
