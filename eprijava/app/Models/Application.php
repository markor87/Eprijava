<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Fluent;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'competition_id',
        'government_body_id',
        'job_position_id',
        'first_name',
        'last_name',
        'national_id',
        'candidate_code',
        'org_unit_path',
        'rank_name',
        'profile_snapshot',
    ];

    protected $casts = [
        'profile_snapshot' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function governmentBody(): BelongsTo
    {
        return $this->belongsTo(GovernmentBody::class);
    }

    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(JobPosition::class);
    }

    public static function buildProfileSnapshot(User $user): array
    {
        $candidate           = $user->candidate?->load(['placeOfBirth', 'addressCity', 'deliveryCity']);
        $highSchoolEducation = $user->highSchoolEducations()->first();
        $higherEducations    = $user->higherEducations()->with(['academicTitle', 'institutionLocation'])->get();
        $workExperiences     = $user->workExperiences()->orderByDesc('period_from')->get();
        $trainings           = $user->trainingSet?->trainings()->with('examType')->orderBy('exam_date')->get() ?? collect();
        $foreignSkillSet     = ForeignLanguageSkillSet::where('user_id', $user->id)
                                   ->with('foreignLanguageSkills.foreignLanguage')->first();
        $additionalTrainings = $user->additionalTrainings()->orderBy('year')->get();
        $declaration         = $user->declaration?->load([
                                   'declarationProofs.requiredProof',
                                   'declarationMinorities.nationalMinority',
                               ]);
        $vacancySource       = $user->vacancySource;
        $computerSkill       = $user->computerSkill;

        return [
            'candidate' => $candidate ? [
                ...$candidate->only($candidate->getFillable()),
                'placeOfBirth' => $candidate->placeOfBirth ? ['name' => $candidate->placeOfBirth->name] : null,
                'addressCity'  => $candidate->addressCity  ? ['name' => $candidate->addressCity->name]  : null,
                'deliveryCity' => $candidate->deliveryCity ? ['name' => $candidate->deliveryCity->name] : null,
            ] : null,

            'highSchoolEducation' => $highSchoolEducation
                ? $highSchoolEducation->only($highSchoolEducation->getFillable())
                : null,

            'higherEducations' => $higherEducations->map(fn($e) => [
                ...$e->only($e->getFillable()),
                'institutionLocation' => $e->institutionLocation ? ['name' => $e->institutionLocation->name] : null,
                'academicTitle'       => $e->academicTitle       ? ['title' => $e->academicTitle->title]     : null,
            ])->all(),

            'workExperiences' => $workExperiences->map(fn($we) => $we->only($we->getFillable()))->all(),

            'trainings' => $trainings->map(fn($t) => [
                ...$t->only($t->getFillable()),
                'examType' => $t->examType ? ['name' => $t->examType->name] : null,
            ])->all(),

            'foreignSkillSet' => $foreignSkillSet ? [
                'foreignLanguageSkills' => $foreignSkillSet->foreignLanguageSkills->map(fn($s) => [
                    ...$s->only($s->getFillable()),
                    'foreignLanguage' => $s->foreignLanguage
                        ? ['language_name' => $s->foreignLanguage->language_name] : null,
                ])->all(),
            ] : null,

            'computerSkill' => $computerSkill
                ? $computerSkill->only($computerSkill->getFillable())
                : null,

            'additionalTrainings' => $additionalTrainings->map(fn($at) => $at->only($at->getFillable()))->all(),

            'declaration' => $declaration ? [
                ...$declaration->only($declaration->getFillable()),
                'declarationProofs' => $declaration->declarationProofs->map(fn($p) => [
                    'declaration_choice' => $p->declaration_choice,
                    'requiredProof'      => $p->requiredProof
                        ? ['proof_description' => $p->requiredProof->proof_description] : null,
                ])->all(),
                'declarationMinorities' => $declaration->declarationMinorities->map(fn($m) => [
                    'choice'           => $m->choice,
                    'nationalMinority' => $m->nationalMinority
                        ? ['minority_name' => $m->nationalMinority->minority_name] : null,
                ])->all(),
            ] : null,

            'vacancySource' => $vacancySource
                ? $vacancySource->only($vacancySource->getFillable())
                : null,
        ];
    }

    public function hydrateSnapshotForPdf(): array
    {
        $s = $this->profile_snapshot;

        // Convert an associative array to a Fluent object, recursively.
        // - Associative arrays become nested Fluent instances.
        // - Lists of objects (arrays) become Collections of Fluent instances.
        // - Lists of scalars stay as plain PHP arrays (needed for array_map/implode in the blade).
        // - Scalars and null pass through unchanged.
        $obj = function (array|null $data) use (&$obj): ?Fluent {
            if ($data === null) return null;
            $nested = [];
            foreach ($data as $key => $value) {
                if (is_array($value) && array_is_list($value) && !empty($value) && is_array($value[0])) {
                    $nested[$key] = collect($value)->map(fn($item) => $obj($item));
                } elseif (is_array($value) && !array_is_list($value)) {
                    $nested[$key] = $obj($value);
                } else {
                    $nested[$key] = $value;
                }
            }
            return new Fluent($nested);
        };

        $col = fn(array $items) => collect($items)->map(fn($item) => $obj($item));

        return [
            'candidate'           => $obj($s['candidate'] ?? null),
            'highSchoolEducation' => $obj($s['highSchoolEducation'] ?? null),
            'higherEducations'    => $col($s['higherEducations'] ?? []),
            'workExperiences'     => $col($s['workExperiences'] ?? []),
            'trainings'           => $col($s['trainings'] ?? []),
            'foreignSkillSet'     => $obj($s['foreignSkillSet'] ?? null),
            'computerSkill'       => $obj($s['computerSkill'] ?? null),
            'additionalTrainings' => $col($s['additionalTrainings'] ?? []),
            'declaration'         => $obj($s['declaration'] ?? null),
            'vacancySource'       => $obj($s['vacancySource'] ?? null),
        ];
    }
}
