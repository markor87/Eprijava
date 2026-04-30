<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionsSeeder extends Seeder
{
    public function run(): void
    {
        $competitionId   = 8;
        $governmentBodyId = 1;

        $positions = [
            [
                'position_name'     => 'Виши порески референт за контролу обвезника',
                'sequence_number'   => 1,
                'organizational_unit' => 'Одсек за контролу пореских обвезника',
                'org_unit_path'     => 'Сектор за контролу / Одсек за контролу пореских обвезника',
                'sector'            => 'Сектор за контролу',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 151,   // Београд (Стари Град)
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 2,
                'title_id'          => 1,     // Виши порески референт
            ],
            [
                'position_name'     => 'Порески саветник за наплату пореза',
                'sequence_number'   => 2,
                'organizational_unit' => 'Одсек за наплату',
                'org_unit_path'     => 'Сектор за наплату / Одсек за наплату',
                'sector'            => 'Сектор за наплату',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 495,   // Нови Сад
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 1,
                'title_id'          => 8,     // Порески саветник
            ],
            [
                'position_name'     => 'Млађи порески саветник — приправник',
                'sequence_number'   => 3,
                'organizational_unit' => 'Одсек за регистрацију обвезника',
                'org_unit_path'     => 'Сектор за регистрацију / Одсек за регистрацију обвезника',
                'sector'            => 'Сектор за регистрацију',
                'employment_type'   => 'Одређено',
                'work_location_id'  => 3477,  // Нишка Бања (Ниш)
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 3,
                'title_id'          => 4,     // Млађи порески саветник - приправник
            ],
            [
                'position_name'     => 'Главни порески саветник за велике пореске обвезнике',
                'sequence_number'   => 4,
                'organizational_unit' => 'Центар за велике пореске обвезнике',
                'org_unit_path'     => 'Сектор за контролу / Центар за велике пореске обвезнике',
                'sector'            => 'Сектор за контролу',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 151,   // Београд (Стари Град)
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 1,
                'title_id'          => 10,    // Главни порески саветник
            ],
            [
                'position_name'     => 'Виши порески сарадник за превентиву и едукацију',
                'sequence_number'   => 5,
                'organizational_unit' => 'Одсек за превентиву',
                'org_unit_path'     => 'Сектор за комуникације / Одсек за превентиву',
                'sector'            => 'Сектор за комуникације',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 1426,  // Крагујевац
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 2,
                'title_id'          => 3,     // Виши порески сарадник
            ],
            [
                'position_name'     => 'Виши порески саветник за управне поступке',
                'sequence_number'   => 6,
                'organizational_unit' => 'Одсек за управно-правне послове',
                'org_unit_path'     => 'Сектор за правне послове / Одсек за управно-правне послове',
                'sector'            => 'Сектор за правне послове',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 151,   // Београд (Стари Град)
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 1,
                'title_id'          => 2,     // Виши порески саветник
            ],
            [
                'position_name'     => 'Млађи порески саветник за информационе технологије',
                'sequence_number'   => 7,
                'organizational_unit' => 'Одсек за информационе системе',
                'org_unit_path'     => 'Сектор за IT / Одсек за информационе системе',
                'sector'            => 'Сектор за IT',
                'employment_type'   => 'Неодређено',
                'work_location_id'  => 151,   // Београд (Стари Град)
                'qualification_level' => 'Висока стручна спрема',
                'executor_count'    => 2,
                'title_id'          => 5,     // Млађи порески саветник
            ],
            [
                'position_name'     => 'Порески референт за обраду пореских пријава',
                'sequence_number'   => 8,
                'organizational_unit' => 'Одсек за обраду пријава',
                'org_unit_path'     => 'Сектор за обраду / Одсек за обраду пријава',
                'sector'            => 'Сектор за обраду',
                'employment_type'   => 'Одређено',
                'work_location_id'  => 495,   // Нови Сад
                'qualification_level' => 'Средња стручна спрема',
                'executor_count'    => 4,
                'title_id'          => 7,     // Порески референт
            ],
        ];

        foreach ($positions as $data) {
            JobPosition::create(array_merge($data, [
                'competition_id'    => $competitionId,
                'government_body_id' => $governmentBodyId,
            ]));
        }
    }
}
