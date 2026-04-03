<?php

namespace Database\Seeders;

use App\Models\AcademicTitle;
use App\Models\ExamType;
use App\Models\ForeignLanguage;
use App\Models\NationalMinority;
use App\Models\Place;
use App\Models\RequiredProof;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestProfilesSeeder extends Seeder
{
    private const TOTAL      = 5000;
    private const CHUNK_SIZE = 500;
    private const NID_BASE   = 9_000_000_000_001; // 13-digit starting point

    private array  $placeIds       = [];
    private array  $titleIds       = [];
    private array  $langIds        = [];
    private array  $examTypeIds    = [];
    private array  $requiredProofs = []; // [{id, proof_type}, ...]
    private array  $minorityIds    = [];
    private int    $nidCounter     = 0;
    private string $now;

    // Fixed pools for enum-style string fields
    private array $studyTypes      = ['academic', 'vocational'];
    private array $employmentBases = ['permanent', 'fixed_term'];
    private array $educationLevels = ['4yr_240espb', '3yr_180espb', '2yr_120espb', 'masters'];
    private array $langLevels      = ['А1', 'А2', 'Б1', 'Б2', 'Ц1', 'Ц2'];
    private array $vacancySources  = ['internet', 'organ', 'hr_services', 'newspaper', 'other'];
    private array $declarationChoices = ['yes', 'no', 'consent'];

    public function run(): void
    {
        $this->now = now()->toDateTimeString();

        $this->placeIds       = Place::pluck('id')->toArray();
        $this->titleIds       = AcademicTitle::pluck('id')->toArray();
        $this->langIds        = ForeignLanguage::pluck('id')->toArray();
        $this->examTypeIds    = ExamType::pluck('id')->toArray();
        $this->requiredProofs = RequiredProof::all(['id', 'proof_type'])->toArray();
        $this->minorityIds    = NationalMinority::pluck('id')->toArray();

        if (empty($this->requiredProofs)) {
            $this->command->error('required_proofs table is empty — populate it first.');
            return;
        }
        if (empty($this->minorityIds)) {
            $this->command->error('national_minorities table is empty — populate it first.');
            return;
        }
        if (empty($this->examTypeIds)) {
            $this->command->error('exam_types table is empty — run migrations first.');
            return;
        }

        $batches = (int) ceil(self::TOTAL / self::CHUNK_SIZE);

        for ($i = 0; $i < $batches; $i++) {
            $count = ($i === $batches - 1)
                ? self::TOTAL - ($i * self::CHUNK_SIZE)
                : self::CHUNK_SIZE;

            $this->command->info('Batch ' . ($i + 1) . "/{$batches} — creating {$count} users...");

            $users = User::factory()->count($count)->create();
            $this->seedBatch($users);
        }

        $this->command->info('Done. Created ' . self::TOTAL . ' test users with full profiles.');
    }

    // ─── BATCH ORCHESTRATION ─────────────────────────────────────────────────

    private function seedBatch($users): void
    {
        $userIds = $users->pluck('id')->toArray();

        $this->insertCandidates($users);
        $this->insertHighSchoolEducations($userIds);
        $this->insertComputerSkills($userIds);
        $this->insertVacancySources($userIds);

        $this->insertHigherEducations($userIds);
        $this->insertWorkExperiences($userIds);
        $this->insertAdditionalTrainings($userIds);

        $this->insertTrainingSets($userIds);
        $this->insertTrainings($userIds);

        $this->insertForeignSkillSets($userIds);
        $this->insertForeignLanguageSkills($userIds);

        $this->insertDeclarations($userIds);
        $this->insertDeclarationChildren($userIds);
    }

    // ─── HELPERS ─────────────────────────────────────────────────────────────

    private function placeId(): int|null
    {
        return empty($this->placeIds) ? null : $this->placeIds[array_rand($this->placeIds)];
    }

    private function titleId(): int|null
    {
        return empty($this->titleIds) ? null : $this->titleIds[array_rand($this->titleIds)];
    }

    private function langId(): int|null
    {
        return empty($this->langIds) ? null : $this->langIds[array_rand($this->langIds)];
    }

    private function examTypeId(): int
    {
        return $this->examTypeIds[array_rand($this->examTypeIds)];
    }

    private function pick(array $arr): mixed
    {
        return $arr[array_rand($arr)];
    }

    private function year(int $from, int $to): int
    {
        return rand($from, $to);
    }

    private function date(int $fromYear, int $toYear): string
    {
        $y = rand($fromYear, $toYear);
        $m = str_pad((string) rand(1, 12), 2, '0', STR_PAD_LEFT);
        $d = str_pad((string) rand(1, 28), 2, '0', STR_PAD_LEFT);
        return "{$y}-{$m}-{$d}";
    }

    private function nid(): string
    {
        return (string) (self::NID_BASE + $this->nidCounter++);
    }

    // ─── CANDIDATES ──────────────────────────────────────────────────────────

    private function insertCandidates($users): void
    {
        $rows = [];
        foreach ($users as $user) {
            $rows[] = [
                'user_id'             => $user->id,
                'first_name'          => 'Test',
                'last_name'           => 'User' . $user->id,
                'national_id'         => $this->nid(),
                'citizenship'         => 'српско',
                'place_of_birth_id'   => $this->placeId(),
                'address_street'      => 'Тестна улица ' . rand(1, 200),
                'address_postal_code' => str_pad((string) rand(11000, 36000), 5, '0', STR_PAD_LEFT),
                'address_city'        => $this->placeId(),
                'delivery_street'     => null,
                'delivery_postal_code'=> null,
                'delivery_city'       => null,
                'other_delivery_methods' => null,
                'phone'               => '06' . rand(10000000, 99999999),
                'email'               => $user->email,
                'alternative_delivery'=> null,
                'created_at'          => $this->now,
                'updated_at'          => $this->now,
            ];
        }
        DB::table('candidates')->insert($rows);
    }

    // ─── HIGH SCHOOL EDUCATIONS ───────────────────────────────────────────────

    private function insertHighSchoolEducations(array $userIds): void
    {
        $directions = ['Природно-математички смер', 'Друштвено-језички смер', 'Правно-административни смер', 'Економски смер'];
        $rows = [];
        foreach ($userIds as $uid) {
            $rows[] = [
                'user_id'              => $uid,
                'institution_name'     => 'Гимназија ' . $uid,
                'institution_location' => 'Београд',
                'duration'             => 4,
                'direction'            => $this->pick($directions),
                'occupation'           => '',
                'graduation_year'      => $this->year(1990, 2010),
                'created_at'           => $this->now,
                'updated_at'           => $this->now,
            ];
        }
        DB::table('high_school_educations')->insert($rows);
    }

    // ─── HIGHER EDUCATIONS (2 per user) ───────────────────────────────────────

    private function insertHigherEducations(array $userIds): void
    {
        $programs = ['Право', 'Економија', 'Менаџмент', 'Информатика', 'Администрација'];
        $rows = [];
        foreach ($userIds as $uid) {
            for ($j = 0; $j < 2; $j++) {
                $from = $this->year(2005, 2015);
                $rows[] = [
                    'user_id'                => $uid,
                    'study_type'             => $this->pick($this->studyTypes),
                    'volume_espb'            => $this->pick([180, 240, 300, 60]),
                    'institution_name'       => 'Универзитет тест ' . $uid,
                    'institution_location_id'=> $this->placeId(),
                    'program_name'           => $this->pick($programs),
                    'title_id'               => $this->titleId(),
                    'graduation_date'        => $this->date($from, $from + 5),
                    'created_at'             => $this->now,
                    'updated_at'             => $this->now,
                ];
            }
        }
        DB::table('higher_educations')->insert($rows);
    }

    // ─── WORK EXPERIENCES (2 per user) ────────────────────────────────────────

    private function insertWorkExperiences(array $userIds): void
    {
        $employers = ['Министарство финансија', 'Пореска управа', 'Општина Нови Сад', 'Служба за кадрове', 'Министарство правде'];
        $titles    = ['Референт', 'Саветник', 'Виши референт', 'Самостални саветник', 'Шеф одсека'];
        $rows = [];
        foreach ($userIds as $uid) {
            $start1 = $this->year(2005, 2012);
            $end1   = $start1 + rand(1, 4);
            $start2 = $end1 + 1;

            $rows[] = [
                'user_id'            => $uid,
                'period_from'        => $this->date($start1, $start1),
                'period_to'          => $this->date($end1, $end1),
                'employer_name'      => $this->pick($employers),
                'job_title'          => $this->pick($titles),
                'job_description'    => 'Обављање административних послова',
                'employment_basis'   => 'fixed_term',
                'required_education' => json_encode([$this->pick($this->educationLevels)]),
                'created_at'         => $this->now,
                'updated_at'         => $this->now,
            ];
            $rows[] = [
                'user_id'            => $uid,
                'period_from'        => $this->date($start2, $start2),
                'period_to'          => null,
                'employer_name'      => $this->pick($employers),
                'job_title'          => $this->pick($titles),
                'job_description'    => 'Руковођење одсеком и координација послова',
                'employment_basis'   => 'permanent',
                'required_education' => json_encode([$this->pick($this->educationLevels)]),
                'created_at'         => $this->now,
                'updated_at'         => $this->now,
            ];
        }
        DB::table('work_experiences')->insert($rows);
    }

    // ─── ADDITIONAL TRAININGS (2 per user) ────────────────────────────────────

    private function insertAdditionalTrainings(array $userIds): void
    {
        $names = [
            'Управљање пројектима', 'Јавне набавке', 'Управно право ЕУ',
            'Управљање људским ресурсима', 'Финансијско управљање',
        ];
        $institutions = ['Национална академија за јавну управу', 'Британски савет', 'GIZ', 'USAID'];
        $rows = [];
        foreach ($userIds as $uid) {
            for ($j = 0; $j < 2; $j++) {
                $rows[] = [
                    'user_id'          => $uid,
                    'training_name'    => $this->pick($names),
                    'institution_name' => $this->pick($institutions),
                    'location_or_level'=> 'Београд / основни ниво',
                    'year'             => $this->year(2010, 2024),
                    'created_at'       => $this->now,
                    'updated_at'       => $this->now,
                ];
            }
        }
        DB::table('additional_trainings')->insert($rows);
    }

    // ─── COMPUTER SKILLS ─────────────────────────────────────────────────────

    private function insertComputerSkills(array $userIds): void
    {
        $rows = [];
        foreach ($userIds as $uid) {
            $rows[] = [
                'user_id'                     => $uid,
                'word_has_certificate'        => true,
                'word_certificate_year'       => $this->year(2005, 2020),
                'word_certificate_attachment' => null,
                'word_exemption_requested'    => false,
                'excel_has_certificate'       => (bool) rand(0, 1),
                'excel_certificate_year'      => null,
                'excel_certificate_attachment'=> null,
                'excel_exemption_requested'   => false,
                'internet_has_certificate'    => false,
                'internet_certificate_year'   => null,
                'internet_certificate_attachment' => null,
                'internet_exemption_requested'=> false,
                'created_at'                  => $this->now,
                'updated_at'                  => $this->now,
            ];
        }
        DB::table('computer_skills')->insert($rows);
    }

    // ─── VACANCY SOURCES ──────────────────────────────────────────────────────

    private function insertVacancySources(array $userIds): void
    {
        $rows = [];
        foreach ($userIds as $uid) {
            $rows[] = [
                'user_id'                 => $uid,
                'source'                  => $this->pick($this->vacancySources),
                'interested_in_other_jobs'=> (bool) rand(0, 1),
                'created_at'              => $this->now,
                'updated_at'              => $this->now,
            ];
        }
        DB::table('vacancy_sources')->insert($rows);
    }

    // ─── TRAINING SETS + TRAININGS (2 per set) ────────────────────────────────

    private function insertTrainingSets(array $userIds): void
    {
        $rows = [];
        foreach ($userIds as $uid) {
            $rows[] = [
                'user_id'    => $uid,
                'created_at' => $this->now,
                'updated_at' => $this->now,
            ];
        }
        DB::table('training_sets')->insert($rows);
    }

    private function insertTrainings(array $userIds): void
    {
        $setIds = DB::table('training_sets')
            ->whereIn('user_id', $userIds)
            ->pluck('id', 'user_id');

        $authorities = [
            'Министарство државне управе и локалне самоуправе',
            'Министарство правде',
            'Управа за инспекцијске послове',
        ];

        $rows = [];
        foreach ($userIds as $uid) {
            $setId = $setIds[$uid] ?? null;
            if ($setId === null) continue;

            for ($j = 0; $j < 2; $j++) {
                $rows[] = [
                    'training_set_id'   => $setId,
                    'exam_type_id'      => $this->examTypeId(),
                    'has_certificate'   => true,
                    'issuing_authority' => $this->pick($authorities),
                    'exam_date'         => $this->date(2008, 2023),
                    'created_at'        => $this->now,
                    'updated_at'        => $this->now,
                ];
            }
        }
        DB::table('trainings')->insert($rows);
    }

    // ─── FOREIGN LANGUAGE SKILL SETS + SKILLS (2 per set) ────────────────────

    private function insertForeignSkillSets(array $userIds): void
    {
        $rows = [];
        foreach ($userIds as $uid) {
            $rows[] = [
                'user_id'                => $uid,
                'certificate_attachment' => json_encode([]),
                'created_at'             => $this->now,
                'updated_at'             => $this->now,
            ];
        }
        DB::table('foreign_language_skill_sets')->insert($rows);
    }

    private function insertForeignLanguageSkills(array $userIds): void
    {
        $setIds = DB::table('foreign_language_skill_sets')
            ->whereIn('user_id', $userIds)
            ->pluck('id', 'user_id');

        $rows = [];
        foreach ($userIds as $uid) {
            $setId = $setIds[$uid] ?? null;
            if ($setId === null) continue;

            // Pick 2 distinct language IDs for this user to avoid duplicates if the table has a unique constraint
            $langs = $this->langIds;
            shuffle($langs);
            $pick = array_slice($langs, 0, min(2, count($langs)));

            foreach ($pick as $langId) {
                $hasCert = (bool) rand(0, 1);
                $rows[] = [
                    'foreign_language_skill_set_id' => $setId,
                    'foreign_language_id'           => $langId,
                    'level'                         => $this->pick($this->langLevels),
                    'has_certificate'               => $hasCert,
                    'year_of_examination'           => $hasCert ? $this->year(2005, 2023) : null,
                    'exemption_requested'           => false,
                    'created_at'                    => $this->now,
                    'updated_at'                    => $this->now,
                ];
            }
        }
        if (!empty($rows)) {
            DB::table('foreign_language_skills')->insert($rows);
        }
    }

    // ─── DECLARATIONS + PROOFS + MINORITIES ──────────────────────────────────

    private function insertDeclarations(array $userIds): void
    {
        $competencyChecked = ['no', 'yes'];
        $dataCollection    = ['by_body', 'personally'];

        $rows = [];
        foreach ($userIds as $uid) {
            $checked = $this->pick($competencyChecked);
            $rows[] = [
                'user_id'                               => $uid,
                'wants_functional_competency_exemption' => (bool) rand(0, 1),
                'behavioral_competency_checked'         => $checked,
                'behavioral_competency_checked_body'    => $checked === 'yes' ? 'Служба за управљање кадровима' : null,
                'behavioral_competency_passed'          => $checked === 'yes' ? $this->pick(['yes', 'no']) : null,
                'special_conditions_needed'             => false,
                'special_conditions_description'        => null,
                'employment_terminated_for_breach'      => false,
                'official_data_collection'              => $this->pick($dataCollection),
                'created_at'                            => $this->now,
                'updated_at'                            => $this->now,
            ];
        }
        DB::table('declarations')->insert($rows);
    }

    private function insertDeclarationChildren(array $userIds): void
    {
        $declIds = DB::table('declarations')
            ->whereIn('user_id', $userIds)
            ->pluck('id', 'user_id');

        $proofRows    = [];
        $minorityRows = [];

        foreach ($userIds as $uid) {
            $declId = $declIds[$uid] ?? null;
            if ($declId === null) continue;

            foreach ($this->requiredProofs as $proof) {
                $choice = $proof['proof_type'] === 'personal' ? 'yes' : 'consent';
                $proofRows[] = [
                    'declaration_id'     => $declId,
                    'required_proof_id'  => $proof['id'],
                    'declaration_choice' => $choice,
                    'created_at'         => $this->now,
                    'updated_at'         => $this->now,
                ];
            }

            foreach ($this->minorityIds as $minId) {
                $minorityRows[] = [
                    'declaration_id'      => $declId,
                    'national_minority_id'=> $minId,
                    'choice'              => 'no',
                    'created_at'          => $this->now,
                    'updated_at'          => $this->now,
                ];
            }
        }

        // Insert in chunks to stay within MySQL's max_allowed_packet limits
        foreach (array_chunk($proofRows, 1000) as $chunk) {
            DB::table('declaration_proofs')->insert($chunk);
        }
        foreach (array_chunk($minorityRows, 1000) as $chunk) {
            DB::table('declaration_minorities')->insert($chunk);
        }
    }
}
