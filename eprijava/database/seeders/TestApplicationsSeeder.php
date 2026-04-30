<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            ['Марко', 'Радовановић'], ['Јована', 'Петровић'], ['Никола', 'Јовановић'],
            ['Ана', 'Николић'], ['Стефан', 'Марковић'], ['Ивана', 'Стојановић'],
            ['Милош', 'Илић'], ['Тамара', 'Павловић'], ['Александар', 'Благојевић'],
            ['Марија', 'Митровић'], ['Немања', 'Тодоровић'], ['Сања', 'Ђорђевић'],
            ['Урош', 'Станковић'], ['Катарина', 'Живковић'], ['Владимир', 'Ристић'],
        ];

        $snapshot = [
            'candidate'           => null,
            'highSchoolEducation' => null,
            'higherEducations'    => [],
            'workExperiences'     => [],
            'trainings'           => [],
            'foreignSkillSet'     => null,
            'computerSkill'       => null,
            'additionalTrainings' => [],
            'declaration'         => null,
            'vacancySource'       => null,
        ];
        $snapshotJson = json_encode($snapshot);
        $now = now()->toDateTimeString();

        $chunk = [];
        $total = 15000;
        $chunkSize = 500;
        $nameCount = count($names);

        for ($i = 1; $i <= $total; $i++) {
            [$first, $last] = $names[$i % $nameCount];
            $chunk[] = [
                'user_id'            => 1,
                'competition_id'     => 1,
                'government_body_id' => 1,
                'job_position_id'    => null,
                'first_name'         => $first,
                'last_name'          => $last,
                'national_id'        => str_pad($i, 13, '0', STR_PAD_LEFT),
                'candidate_code'     => 'TEST-' . str_pad($i, 6, '0', STR_PAD_LEFT),
                'org_unit_path'      => null,
                'rank_name'          => null,
                'profile_snapshot'   => $snapshotJson,
                'created_at'         => $now,
                'updated_at'         => $now,
            ];

            if (count($chunk) === $chunkSize) {
                DB::table('applications')->insert($chunk);
                $chunk = [];
            }
        }

        if (!empty($chunk)) {
            DB::table('applications')->insert($chunk);
        }

        $this->command->info("Inserted {$total} test applications for competition 1.");
    }
}
