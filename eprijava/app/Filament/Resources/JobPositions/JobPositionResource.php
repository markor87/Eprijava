<?php

namespace App\Filament\Resources\JobPositions;

use App\Filament\Resources\JobPositions\Pages\CreateJobPosition;
use App\Filament\Resources\JobPositions\Pages\EditJobPosition;
use App\Filament\Resources\JobPositions\Pages\ListJobPositions;
use App\Filament\Resources\JobPositions\Schemas\JobPositionForm;
use App\Filament\Resources\JobPositions\Tables\JobPositionsTable;
use App\Models\JobPosition;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class JobPositionResource extends Resource
{
    protected static ?string $model = JobPosition::class;

    protected static ?string $slug = 'job-positions';

    protected static bool $shouldRegisterNavigation = false;

    protected static ?string $modelLabel = 'Радно место';

    protected static ?string $pluralModelLabel = 'Радна места';

    public static function canAccess(): bool
    {
        $user = Auth::user();
        return $user && ($user->hasRole('super_admin') || $user->can('ViewAny:JobPosition'));
    }

    public static function form(Schema $schema): Schema
    {
        return JobPositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return JobPositionsTable::configure($table);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $path = request()->path();

        // Livewire AJAX requests (actions, polling) — no filtering
        if (str_contains($path, 'livewire')) {
            return $query;
        }

        // Edit/create pages use record ID in the path — no filtering
        if (preg_match('#/job-positions/\d#', $path)) {
            return $query;
        }

        // List page — filter by competition_id from URL
        $competitionId = request()->query('competition_id');

        if (!$competitionId) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('competition_id', $competitionId);
    }

    public static function getPages(): array
    {
        return [
            'index'  => ListJobPositions::route('/'),
            'create' => CreateJobPosition::route('/create'),
            'edit'   => EditJobPosition::route('/{record}/edit'),
        ];
    }
}
