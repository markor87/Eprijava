<?php

namespace App\Filament\Resources\Declarations\Pages;

use App\Filament\Resources\Declarations\DeclarationResource;
use App\Models\RequiredProof;
use Filament\Resources\Pages\EditRecord;

class EditDeclaration extends EditRecord
{
    protected static string $resource = DeclarationResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $allProofIds = RequiredProof::orderBy('sort_order')->pluck('id');
        $existingProofIds = $this->record->declarationProofs()->pluck('required_proof_id');

        $allProofIds->diff($existingProofIds)->each(function ($proofId) {
            $this->record->declarationProofs()->create([
                'required_proof_id'  => $proofId,
                'declaration_choice' => null,
            ]);
        });

        return $data;
    }
}
