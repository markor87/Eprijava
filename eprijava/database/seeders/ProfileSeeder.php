<?php

namespace Database\Seeders;

use App\Models\AdditionalTraining;
use App\Models\Candidate;
use App\Models\ComputerSkill;
use App\Models\Declaration;
use App\Models\DeclarationMinority;
use App\Models\DeclarationProof;
use App\Models\ForeignLanguageSkill;
use App\Models\ForeignLanguageSkillSet;
use App\Models\HigherEducation;
use App\Models\HighSchoolEducation;
use App\Models\NationalMinority;
use App\Models\RequiredProof;
use App\Models\ExamType;
use App\Models\Training;
use App\Models\TrainingSet;
use App\Models\User;
use App\Models\VacancySource;
use App\Models\WorkExperience;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        User::all()->each(fn($user) => $this->seedUser($user));
    }

    private function seedUser(User $user): void
    {
        $this->command->info("Seeding profile for user {$user->id}: {$user->name}");

        $this->seedCandidate($user);
        $this->seedHighSchoolEducation($user);
        $this->seedHigherEducation($user);
        $this->seedWorkExperiences($user);
        $this->seedTrainings($user);
        $this->seedAdditionalTrainings($user);
        $this->seedForeignLanguageSkills($user);
        $this->seedComputerSkill($user);
        $this->seedDeclaration($user);
        $this->seedVacancySource($user);
    }

    // ─── CANDIDATE ────────────────────────────────────────────────────────────

    private function seedCandidate(User $user): void
    {
        if ($user->candidate) {
            return;
        }

        $profiles = [
            1 => [
                'first_name'          => 'Александар',
                'last_name'           => 'Николић',
                'national_id'         => '0505985710123',
                'citizenship'         => 'српско',
                'place_of_birth_id'   => 151,
                'address_street'      => 'Кнез Михајлова 12',
                'address_postal_code' => '11000',
                'address_city'        => 151,
                'phone'               => '0641234567',
                'email'               => $user->email,
            ],
            2 => [
                'first_name'          => 'Марко',
                'last_name'           => 'Радовановић',
                'national_id'         => '1503987710045',
                'citizenship'         => 'српско',
                'place_of_birth_id'   => 151,
                'address_street'      => 'Булевар Михајла Пупина 10',
                'address_postal_code' => '11070',
                'address_city'        => 151,
                'phone'               => '0638765432',
                'email'               => $user->email,
            ],
        ];

        $data = $profiles[$user->id] ?? [
            'first_name'          => 'Корисник',
            'last_name'           => 'Профил',
            'national_id'         => str_pad($user->id, 13, '0', STR_PAD_LEFT),
            'citizenship'         => 'српско',
            'place_of_birth_id'   => 151,
            'address_street'      => 'Немањина 11',
            'address_postal_code' => '11000',
            'address_city'        => 151,
            'phone'               => '0600000000',
            'email'               => $user->email,
        ];

        Candidate::create(array_merge(['user_id' => $user->id], $data));
    }

    // ─── HIGH SCHOOL EDUCATION ────────────────────────────────────────────────

    private function seedHighSchoolEducation(User $user): void
    {
        if ($user->highSchoolEducations()->exists()) {
            return;
        }

        $records = [
            1 => [
                'institution_name'     => 'Гимназија „Јован Јовановић Змај"',
                'institution_location' => 'Нови Сад',
                'duration'             => 4,
                'direction'            => 'Природно-математички смер',
                'occupation'           => '',
                'graduation_year'      => 2003,
            ],
            2 => [
                'institution_name'     => 'Правно-пословна школа',
                'institution_location' => 'Београд',
                'duration'             => 4,
                'direction'            => 'Правно-административни смер',
                'occupation'           => 'Правно-административни техничар',
                'graduation_year'      => 2005,
            ],
        ];

        $data = $records[$user->id] ?? [
            'institution_name'     => 'Гимназија',
            'institution_location' => 'Београд',
            'duration'             => 4,
            'direction'            => 'Друштвено-језички смер',
            'occupation'           => '',
            'graduation_year'      => 2004,
        ];

        HighSchoolEducation::create(array_merge(['user_id' => $user->id], $data));
    }

    // ─── HIGHER EDUCATION ─────────────────────────────────────────────────────

    private function seedHigherEducation(User $user): void
    {
        if ($user->higherEducations()->exists()) {
            return;
        }

        $records = [
            1 => [[
                'study_type'              => 'academic',
                'volume_espb'             => 240,
                'institution_name'        => 'Универзитет у Новом Саду, Правни факултет',
                'institution_location_id' => 495,
                'program_name'            => 'Право',
                'title_id'                => 442,   // дипломирани правник
                'graduation_date'         => '2008-10-15',
            ]],
            2 => [
                [
                    'study_type'              => 'academic',
                    'volume_espb'             => 240,
                    'institution_name'        => 'Универзитет у Београду, Правни факултет',
                    'institution_location_id' => 151,
                    'program_name'            => 'Право',
                    'title_id'                => 442,   // дипломирани правник
                    'graduation_date'         => '2010-06-30',
                ],
                [
                    'study_type'              => 'academic',
                    'volume_espb'             => 60,
                    'institution_name'        => 'Универзитет у Београду, Правни факултет',
                    'institution_location_id' => 151,
                    'program_name'            => 'Јавно право',
                    'title_id'                => 447,   // мастер права
                    'graduation_date'         => '2012-09-20',
                ],
            ],
        ];

        $list = $records[$user->id] ?? [[
            'study_type'              => 'academic',
            'volume_espb'             => 240,
            'institution_name'        => 'Универзитет у Београду, Факултет организационих наука',
            'institution_location_id' => 151,
            'program_name'            => 'Менаџмент и организација',
            'title_id'                => 328,   // дипломирани економиста
            'graduation_date'         => '2009-07-01',
        ]];

        foreach ($list as $data) {
            HigherEducation::create(array_merge(['user_id' => $user->id], $data));
        }
    }

    // ─── WORK EXPERIENCES ─────────────────────────────────────────────────────

    private function seedWorkExperiences(User $user): void
    {
        if ($user->workExperiences()->exists()) {
            return;
        }

        $records = [
            1 => [
                [
                    'period_from'       => '2008-11-01',
                    'period_to'         => '2012-05-31',
                    'employer_name'     => 'Министарство финансија',
                    'job_title'         => 'Порески инспектор',
                    'job_description'   => 'Контрола пореских обвезника и провера пореских пријава',
                    'employment_basis'  => 'permanent',
                    'required_education'=> ['4yr_240espb'],
                ],
                [
                    'period_from'       => '2012-06-01',
                    'period_to'         => null,
                    'employer_name'     => 'Пореска управа',
                    'job_title'         => 'Виши порески референт',
                    'job_description'   => 'Спровођење поступка контроле пореских обвезника, примена прописа из области пореза',
                    'employment_basis'  => 'permanent',
                    'required_education'=> ['4yr_240espb'],
                ],
            ],
            2 => [
                [
                    'period_from'       => '2010-10-01',
                    'period_to'         => '2013-03-31',
                    'employer_name'     => 'Адвокатска канцеларија Јовановић и партнери',
                    'job_title'         => 'Адвокатски приправник',
                    'job_description'   => 'Израда правних поднесака, учешће у судским поступцима, правно саветовање клијената',
                    'employment_basis'  => 'fixed_term',
                    'required_education'=> ['4yr_240espb'],
                ],
                [
                    'period_from'       => '2013-04-01',
                    'period_to'         => '2018-12-31',
                    'employer_name'     => 'Министарство државне управе и локалне самоуправе',
                    'job_title'         => 'Саветник за управно-правне послове',
                    'job_description'   => 'Припрема прописа из области локалне самоуправе, давање правних мишљења, учешће у изради аката',
                    'employment_basis'  => 'permanent',
                    'required_education'=> ['4yr_240espb'],
                ],
                [
                    'period_from'       => '2019-01-01',
                    'period_to'         => null,
                    'employer_name'     => 'Служба за управљање кадровима',
                    'job_title'         => 'Самостални саветник',
                    'job_description'   => 'Управљање поступцима јавних конкурса, примена прописа из области радних односа у државним органима',
                    'employment_basis'  => 'permanent',
                    'required_education'=> ['4yr_240espb'],
                ],
            ],
        ];

        $list = $records[$user->id] ?? [[
            'period_from'        => '2015-01-01',
            'period_to'          => null,
            'employer_name'      => 'Државни орган',
            'job_title'          => 'Референт',
            'job_description'    => 'Обављање административних послова',
            'employment_basis'   => 'permanent',
            'required_education' => ['4yr_240espb'],
        ]];

        foreach ($list as $data) {
            WorkExperience::create(array_merge(['user_id' => $user->id], $data));
        }
    }

    // ─── TRAININGS (СТРУЧНИ ИСПИТИ) ───────────────────────────────────────────

    private function seedTrainings(User $user): void
    {
        if (TrainingSet::where('user_id', $user->id)->exists()) {
            return;
        }

        $set = TrainingSet::create(['user_id' => $user->id]);

        $typeId = fn(string $name) => ExamType::where('name', $name)->value('id');

        $records = [
            1 => [
                [
                    'exam_type_id'      => $typeId('Државни стручни испит'),
                    'has_certificate'   => true,
                    'issuing_authority' => 'Министарство државне управе и локалне самоуправе',
                    'exam_date'         => '2010-04-22',
                ],
            ],
            2 => [
                [
                    'exam_type_id'      => $typeId('Државни стручни испит'),
                    'has_certificate'   => true,
                    'issuing_authority' => 'Министарство државне управе и локалне самоуправе',
                    'exam_date'         => '2014-11-18',
                ],
                [
                    'exam_type_id'      => $typeId('Правосудни испит'),
                    'has_certificate'   => true,
                    'issuing_authority' => 'Министарство правде',
                    'exam_date'         => '2013-06-05',
                ],
            ],
        ];

        $list = $records[$user->id] ?? [[
            'exam_type_id'      => $typeId('Државни стручни испит'),
            'has_certificate'   => true,
            'issuing_authority' => 'Министарство државне управе и локалне самоуправе',
            'exam_date'         => '2016-05-10',
        ]];

        foreach ($list as $data) {
            $set->trainings()->create($data);
        }
    }

    // ─── ADDITIONAL TRAININGS ─────────────────────────────────────────────────

    private function seedAdditionalTrainings(User $user): void
    {
        if ($user->additionalTrainings()->exists()) {
            return;
        }

        $records = [
            1 => [
                [
                    'training_name'    => 'Управљање пројектима у јавном сектору',
                    'institution_name' => 'Национална академија за јавну управу',
                    'location_or_level'=> 'Београд / напредни ниво',
                    'year'             => 2015,
                ],
                [
                    'training_name'    => 'Енглески језик',
                    'institution_name' => 'Британски савет',
                    'location_or_level'=> 'Нови Сад / Б2 ниво',
                    'year'             => 2019,
                ],
            ],
            2 => [
                [
                    'training_name'    => 'Управно право ЕУ',
                    'institution_name' => 'Национална академија за јавну управу',
                    'location_or_level'=> 'Београд / напредни ниво',
                    'year'             => 2020,
                ],
                [
                    'training_name'    => 'Управљање људским ресурсима',
                    'institution_name' => 'Национална академија за јавну управу',
                    'location_or_level'=> 'Београд / основни ниво',
                    'year'             => 2021,
                ],
                [
                    'training_name'    => 'Енглески језик',
                    'institution_name' => 'Институт за стране језике',
                    'location_or_level'=> 'Београд / Ц1 ниво',
                    'year'             => 2022,
                ],
            ],
        ];

        $list = $records[$user->id] ?? [[
            'training_name'     => 'Основи јавне управе',
            'institution_name'  => 'Национална академија за јавну управу',
            'location_or_level' => 'Београд / основни ниво',
            'year'              => 2018,
        ]];

        foreach ($list as $data) {
            AdditionalTraining::create(array_merge(['user_id' => $user->id], $data));
        }
    }

    // ─── FOREIGN LANGUAGE SKILLS ──────────────────────────────────────────────

    private function seedForeignLanguageSkills(User $user): void
    {
        if (ForeignLanguageSkillSet::where('user_id', $user->id)->exists()) {
            return;
        }

        $set = ForeignLanguageSkillSet::create([
            'user_id'                => $user->id,
            'certificate_attachment' => [],
        ]);

        $skills = [
            1 => [
                ['foreign_language_id' => 1, 'level' => 'Б2', 'has_certificate' => true,  'year_of_examination' => 2018, 'exemption_requested' => false],
            ],
            2 => [
                ['foreign_language_id' => 1, 'level' => 'Ц1', 'has_certificate' => true,  'year_of_examination' => 2022, 'exemption_requested' => true],
            ],
        ];

        $list = $skills[$user->id] ?? [
            ['foreign_language_id' => 1, 'level' => 'Б1', 'has_certificate' => false, 'year_of_examination' => null, 'exemption_requested' => false],
        ];

        foreach ($list as $data) {
            ForeignLanguageSkill::create(array_merge(
                ['foreign_language_skill_set_id' => $set->id],
                $data
            ));
        }
    }

    // ─── COMPUTER SKILL ───────────────────────────────────────────────────────

    private function seedComputerSkill(User $user): void
    {
        if ($user->computerSkill) {
            return;
        }

        $records = [
            1 => [
                'word_has_certificate'         => true,
                'word_certificate_year'        => 2010,
                'word_exemption_requested'     => false,
                'excel_has_certificate'        => true,
                'excel_certificate_year'       => 2010,
                'excel_exemption_requested'    => false,
                'internet_has_certificate'     => false,
                'internet_certificate_year'    => null,
                'internet_exemption_requested' => false,
            ],
            2 => [
                'word_has_certificate'         => true,
                'word_certificate_year'        => 2015,
                'word_exemption_requested'     => true,
                'excel_has_certificate'        => true,
                'excel_certificate_year'       => 2015,
                'excel_exemption_requested'    => true,
                'internet_has_certificate'     => true,
                'internet_certificate_year'    => 2015,
                'internet_exemption_requested' => true,
            ],
        ];

        $data = $records[$user->id] ?? [
            'word_has_certificate'         => true,
            'word_certificate_year'        => 2012,
            'word_exemption_requested'     => false,
            'excel_has_certificate'        => false,
            'excel_certificate_year'       => null,
            'excel_exemption_requested'    => false,
            'internet_has_certificate'     => false,
            'internet_certificate_year'    => null,
            'internet_exemption_requested' => false,
        ];

        ComputerSkill::create(array_merge(['user_id' => $user->id], $data));
    }

    // ─── DECLARATION ──────────────────────────────────────────────────────────

    private function seedDeclaration(User $user): void
    {
        if ($user->declaration) {
            return;
        }

        $records = [
            1 => [
                'wants_functional_competency_exemption' => false,
                'behavioral_competency_checked'         => 'no',
                'behavioral_competency_checked_body'    => null,
                'behavioral_competency_passed'          => null,
                'special_conditions_needed'             => false,
                'special_conditions_description'        => null,
                'employment_terminated_for_breach'      => false,
                'official_data_collection'              => 'by_body',
            ],
            2 => [
                'wants_functional_competency_exemption' => true,
                'behavioral_competency_checked'         => 'yes',
                'behavioral_competency_checked_body'    => 'Служба за управљање кадровима',
                'behavioral_competency_passed'          => 'yes',
                'special_conditions_needed'             => false,
                'special_conditions_description'        => null,
                'employment_terminated_for_breach'      => false,
                'official_data_collection'              => 'personally',
            ],
        ];

        $data = $records[$user->id] ?? [
            'wants_functional_competency_exemption' => false,
            'behavioral_competency_checked'         => 'no',
            'behavioral_competency_checked_body'    => null,
            'behavioral_competency_passed'          => null,
            'special_conditions_needed'             => false,
            'special_conditions_description'        => null,
            'employment_terminated_for_breach'      => false,
            'official_data_collection'              => 'by_body',
        ];

        $declaration = Declaration::create(array_merge(['user_id' => $user->id], $data));

        // Seed declaration proofs for all required proofs
        RequiredProof::all()->each(function ($proof) use ($declaration) {
            $choice = $proof->proof_type === 'personal' ? 'yes' : 'consent';
            DeclarationProof::create([
                'declaration_id'    => $declaration->id,
                'required_proof_id' => $proof->id,
                'declaration_choice'=> $choice,
            ]);
        });

        // Seed declaration minorities for all national minorities
        NationalMinority::all()->each(function ($minority) use ($declaration) {
            DeclarationMinority::create([
                'declaration_id'      => $declaration->id,
                'national_minority_id'=> $minority->id,
                'choice'              => 'no',
            ]);
        });
    }

    // ─── VACANCY SOURCE ───────────────────────────────────────────────────────

    private function seedVacancySource(User $user): void
    {
        if ($user->vacancySource) {
            return;
        }

        $records = [
            1 => ['source' => 'hr_services',  'interested_in_other_jobs' => false],
            2 => ['source' => 'organ',         'interested_in_other_jobs' => true],
        ];

        $data = $records[$user->id] ?? ['source' => 'internet', 'interested_in_other_jobs' => false];

        VacancySource::create(array_merge(['user_id' => $user->id], $data));
    }
}
