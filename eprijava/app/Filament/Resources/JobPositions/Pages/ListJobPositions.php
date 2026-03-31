<?php

namespace App\Filament\Resources\JobPositions\Pages;

use App\Filament\Resources\JobPositions\JobPositionResource;
use App\Models\Competition;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJobPositions extends ListRecords
{
    protected static string $resource = JobPositionResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }

    public function getTitle(): string
    {
        $competitionId = request()->query('competition_id');

        if ($competitionId) {
            $competition = Competition::find($competitionId);
            if ($competition) {
                return 'Радна места — ' . $competition->tip_konkursa . ' (' . $competition->datum_od->format('d.m.Y') . ')';
            }
        }

        return 'Радна места';
    }

    protected function getHeaderActions(): array
    {
        $competitionId = request()->query('competition_id');

        return [
            CreateAction::make()
                ->label('Додај радно место')
                ->url(JobPositionResource::getUrl('create') . '?competition_id=' . $competitionId),
        ];
    }
}
