<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RanksSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reference_ranks')->truncate();

        $ranks = [
            ['name' => 'Виши порески референт'],
            ['name' => 'Виши порески саветник'],
            ['name' => 'Виши порески сарадник'],
            ['name' => 'Млађи порески саветник - приправник'],
            ['name' => 'Млађи порески саветник'],
            ['name' => 'Млађи порески сарадник'],
            ['name' => 'Порески референт'],
            ['name' => 'Порески саветник'],
            ['name' => 'Порески саветник I'],
            ['name' => 'Главни порески саветник'],
        ];

        DB::table('reference_ranks')->insert($ranks);
    }
}
