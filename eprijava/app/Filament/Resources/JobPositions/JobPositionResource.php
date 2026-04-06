<?php

namespace App\Filament\Resources\JobPositions;

use App\Filament\Resources\JobPositions\Pages\CreateJobPosition;
use App\Filament\Resources\JobPositions\Pages\EditJobPosition;
use App\Filament\Resources\JobPositions\Pages\ListJobPositions;
use App\Filament\Resources\JobPositions\Schemas\JobPositionForm;
use App\Filament\Resources\JobPositions\Tables\JobPositionsTable;
use App\Models\HigherEducation;
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
        $path  = request()->path();

        // Edit/create pages — no filtering
        if (preg_match('#/job-positions/\d#', $path)) {
            return $query;
        }

        // For Livewire AJAX requests the competition_id is on the Referer URL, not the request URL
        $competitionId = request()->query('competition_id');
        if (!$competitionId) {
            $referer = request()->header('Referer', '');
            parse_str(parse_url($referer, PHP_URL_QUERY) ?? '', $refererParams);
            $competitionId = $refererParams['competition_id'] ?? null;
        }

        if (!$competitionId) {
            return $query->whereRaw('1 = 0');
        }

        $query->where('competition_id', $competitionId);

        // Education-level filter — skip for super_admin
        if (!Auth::user()?->hasRole('super_admin')) {
            $userId    = Auth::id();
            $totalEspb = (int) HigherEducation::where('user_id', $userId)->sum('volume_espb');
            $count     = HigherEducation::where('user_id', $userId)->count();

            if ($count === 0 || $totalEspb < 180) {
                $allowedLevels    = ['ССС'];
                $fieldMatchLevels = [];
            } elseif ($totalEspb === 180 || ($count > 1 && $totalEspb > 180 && $totalEspb < 240)) {
                $allowedLevels    = ['ССС', 'ВШС'];
                $fieldMatchLevels = ['ВШС'];
            } elseif ($count === 1 && $totalEspb > 180) {
                $allowedLevels    = ['ССС', 'ВСС'];
                $fieldMatchLevels = ['ВСС'];
            } else {
                // Multiple records, sum >= 240
                $allowedLevels    = ['ССС', 'ВШС', 'ВСС'];
                $fieldMatchLevels = ['ВШС', 'ВСС'];
            }

            $query->whereIn('qualification_level', $allowedLevels)
                  ->where(function ($q) use ($userId, $fieldMatchLevels) {
                      $q->where('qualification_level', 'ССС');

                      if (!empty($fieldMatchLevels)) {
                          // Positions with no field requirements
                          $q->orWhere(function ($q2) use ($fieldMatchLevels) {
                              $q2->whereIn('qualification_level', $fieldMatchLevels)
                                 ->where(function ($q3) {
                                     $q3->whereNull('educational_scientific_field_id')
                                        ->orWhere('educational_scientific_field_id', '');
                                 })
                                 ->where(function ($q3) {
                                     $q3->whereNull('scientific_professional_field_id')
                                        ->orWhere('scientific_professional_field_id', '');
                                 });
                          });

                          // Positions where fields match user's academic title(s)
                          $q->orWhere(function ($q2) use ($fieldMatchLevels, $userId) {
                              $q2->whereIn('qualification_level', $fieldMatchLevels)
                                 ->whereExists(function ($sub) use ($userId) {
                                     $sub->from('higher_educations as he')
                                         ->join('academic_titles as at', 'he.title_id', '=', 'at.id')
                                         ->where('he.user_id', $userId)
                                         ->whereColumn('at.educational_scientific_field', 'job_positions.educational_scientific_field_id')
                                         ->whereColumn('at.scientific_professional_area', 'job_positions.scientific_professional_field_id');
                                 });
                          });
                      }
                  });
        }

        return $query;
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
