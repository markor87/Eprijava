<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Pages;

use App\Filament\Resources\ForeignLanguageSkills\ForeignLanguageSkillResource;
use App\Models\ForeignLanguage;
use App\Models\ForeignLanguageSkillSet;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditForeignLanguageSkill extends EditRecord
{
    protected static string $resource = ForeignLanguageSkillResource::class;

    protected function resolveRecord(int|string $key): Model
    {
        return ForeignLanguageSkillSet::findOrFail($key);
    }

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
