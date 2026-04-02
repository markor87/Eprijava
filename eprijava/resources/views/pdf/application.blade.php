<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: 'DejaVu Sans', sans-serif;
        font-size: 9pt;
        color: #000;
        margin: 0;
        padding: 0;
    }
    .page-wrap {
        padding: 12mm 15mm;
    }
    h1 {
        text-align: center;
        font-size: 15pt;
        font-weight: bold;
        margin: 0 0 2px 0;
    }
    .subtitle {
        text-align: center;
        font-size: 10pt;
        margin: 0 0 12px 0;
    }
    .section-title {
        background: #cccccc;
        font-weight: bold;
        padding: 4px 6px;
        font-size: 9pt;
        margin-top: 8px;
        margin-bottom: 0;
    }
    .section-subtitle {
        font-style: italic;
        font-size: 8pt;
        padding: 1px 6px 3px;
        color: #444;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 3px;
    }
    td, th {
        border: 1px solid #888;
        padding: 3px 5px;
        vertical-align: top;
        font-size: 9pt;
    }
    th {
        background: #e8e8e8;
        font-weight: bold;
        font-size: 8pt;
        text-align: left;
    }
    .lbl {
        background: #f2f2f2;
        font-weight: bold;
        width: 42%;
    }
    .lbl-wide {
        background: #f2f2f2;
        font-weight: bold;
        width: 65%;
    }
    .note {
        font-size: 8pt;
        font-style: italic;
        color: #555;
        padding: 3px 6px;
    }
    .sub-heading {
        font-weight: bold;
        font-size: 9pt;
        padding: 4px 0 2px;
    }
    .page-break {
        page-break-before: always;
    }
    .sig-table td {
        border: none;
        padding-top: 15px;
    }
</style>
</head>
<body>
<div class="page-wrap">

<?php
$yn     = fn($v) => $v ? 'Да' : 'Не';
$ynNull = fn($v) => is_null($v) ? '—' : ($v ? 'Да' : 'Не');
$fmt    = fn($d) => $d ? \Carbon\Carbon::parse($d)->format('d.m.Y') : '—';

$employmentBasisLabels = [
    'fixed_term' => 'уговор / решење на одређено време',
    'permanent'  => 'уговор / решење на неодређено време',
    'other'      => 'други уговор',
];

$requiredEducationLabels = [
    'high_school'  => 'средња школа/гимназија',
    '3yr_180espb'  => 'студије до 3 год. / 180 ЕСПБ',
    '4yr_240espb'  => 'основне студије ≥4 год. / академске / специјалистичке струковне',
];

$behavioralPassedLabels = [
    'yes'           => 'Да',
    'no'            => 'Не',
    'dont_remember' => 'Не сећам се',
];

$officialDataLabels = [
    'personally' => 'Лично ћу прибавити и доставити доказе',
    'by_body'    => 'Желим да орган прибави доказе из службених евиденција',
];

$declarationChoiceLabels = [
    'consent'             => 'Сагласан сам да орган прибави овај доказ из службених евиденција',
    'personally_obtained' => 'Лично сам прибавио доказ и достављам га уз ову пријаву',
    'yes'                 => 'Да',
    'no'                  => 'Не',
];

$sourceLabels = [
    'hr_services'             => 'Интернет презентација — Службе за управљање кадровима',
    'organ'                   => 'Интернет презентација — Органа',
    'internet_other'          => 'Интернет презентација — друго',
    'daily_newspapers'        => 'Штампа — Дневне новине',
    'press_other'             => 'Штампа — друго',
    'employee'                => 'Преко пријатеља и познаника — Запослени у органу',
    'manager'                 => 'Преко пријатеља и познаника — Руководилац у органу',
    'referral_other'          => 'Преко пријатеља и познаника — друго',
    'internet'                => 'Национална служба за запошљавање — Интернет презентација',
    'jobs_list'               => 'Национална служба за запошљавање — Лист Послови',
    'advisor_invitation'      => 'Национална служба за запошљавање — Позив саветника из НСЗ',
    'job_fair'                => 'Уживо — Сајам запошљавања',
    'hr_unit'                 => 'Уживо — Кадровска јединица органа — претходни конкурс',
    'university_presentation' => 'Уживо — Презентација на факултету',
];
?>

<h1>{{ $record->governmentBody?->name ?? '—' }}</h1>
<div class="subtitle">Датум објављивања конкурса: {{ $fmt($record->competition?->datum_od) }}</div>
<div class="subtitle" style="font-weight: bold;">Образац пријаве</div>

{{-- ─── 1. ПОДАЦИ О КОНКУРСУ ─── --}}
<div class="section-title">Подаци о конкурсу</div>
<table>
    <tr>
        <td class="lbl">Радно место</td>
        <td>{{ $record->jobPosition?->position_name ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Шифра пријаве</td>
        <td>{{ $record->candidate_code ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Звање/положај</td>
        <td>{{ $record->rank_name ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Државни орган</td>
        <td>{{ $record->governmentBody?->name ?? '—' }}</td>
    </tr>
</table>

{{-- ─── 2. ЛИЧНИ ПОДАЦИ ─── --}}
<div class="section-title">Лични подаци</div>
<table>
    <tr>
        <td class="lbl">Презиме</td>
        <td>{{ $candidate?->last_name ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Иme</td>
        <td>{{ $candidate?->first_name ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Матични број</td>
        <td>{{ $candidate?->national_id ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Državljanstvo</td>
        <td>{{ $candidate?->citizenship ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Место рођења</td>
        <td>{{ $candidate?->placeOfBirth?->name ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl" rowspan="2">Адреса пребивалишта</td>
        <td>{{ $candidate?->address_street ?? '—' }}</td>
    </tr>
    <tr>
        <td>
            {{ $candidate?->address_postal_code ?? '' }}
            {{ $candidate?->addressCity?->name ?? '' }}
        </td>
    </tr>
</table>

{{-- ─── 3. ПОДАЦИ ЗА ОБАВЕШТАВАЊЕ ─── --}}
<div class="section-title">Подаци за обавештавање кандидата у изборном поступку</div>
<table>
    @if($candidate?->delivery_street || $candidate?->deliveryCity)
    <tr>
        <td class="lbl" rowspan="2">Адреса за доставу</td>
        <td>{{ $candidate->delivery_street ?? '—' }}</td>
    </tr>
    <tr>
        <td>{{ $candidate->delivery_postal_code ?? '' }} {{ $candidate->deliveryCity?->name ?? '' }}</td>
    </tr>
    @endif
    <tr>
        <td class="lbl">Остали начини доставе обавештења</td>
        <td>{{ $candidate?->other_delivery_methods ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Број телефона</td>
        <td>{{ $candidate?->phone ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl">Е-адреса</td>
        <td>{{ $candidate?->email ?? '—' }}</td>
    </tr>
    @if($candidate?->alternative_delivery)
    <tr>
        <td class="lbl">Алтернативни начин доставе</td>
        <td>{{ $candidate->alternative_delivery }}</td>
    </tr>
    @endif
</table>

{{-- ─── 4. СРЕДЊА ШКОЛА ─── --}}
<div class="section-title">Образовање — Средња школа/гимназија</div>
@if($highSchoolEducation)
<table>
    <tr>
        <th style="width:30%">Назив завршене школе и седиште</th>
        <th style="width:22%">Трајање образовања и смер</th>
        <th style="width:28%">Занимање које сте стекли</th>
        <th style="width:20%">Год. завршетка</th>
    </tr>
    <tr>
        <td>{{ $highSchoolEducation->institution_name }}, {{ $highSchoolEducation->institution_location }}</td>
        <td>{{ $highSchoolEducation->duration }} год. — {{ $highSchoolEducation->direction }}</td>
        <td>{{ $highSchoolEducation->occupation }}</td>
        <td>{{ $highSchoolEducation->graduation_year }}</td>
    </tr>
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 5. ВИСОКО ОБРАЗОВАЊЕ ─── --}}
<div class="section-title">Образовање — Високо образовање</div>
@if($higherEducations->isNotEmpty())
<table>
    <tr>
        <th style="width:28%">Назив установе и место</th>
        <th style="width:12%">ЕСПБ / год.</th>
        <th style="width:40%">Студијски програм и звање</th>
        <th style="width:20%">Датум завршетка</th>
    </tr>
    @foreach($higherEducations as $edu)
    <tr>
        <td>{{ $edu->institution_name }}@if($edu->institutionLocation), {{ $edu->institutionLocation->name }}@endif</td>
        <td>{{ $edu->volume_espb }}</td>
        <td>{{ $edu->program_name }}@if($edu->academicTitle) — {{ $edu->academicTitle->title }}@endif</td>
        <td>{{ $fmt($edu->graduation_date) }}</td>
    </tr>
    @endforeach
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 6. РАДНО ИСКУСТВО ─── --}}
<div class="section-title">Радно искуство</div>
@if($workExperiences->isNotEmpty())
    @foreach($workExperiences as $we)
    <table style="margin-bottom:5px;">
        <tr>
            <td class="lbl">Период радног ангажмана</td>
            <td>{{ $fmt($we->period_from) }} — {{ $we->period_to ? $fmt($we->period_to) : 'тренутно' }}</td>
        </tr>
        <tr>
            <td class="lbl">Назив послодавца</td>
            <td>{{ $we->employer_name }}</td>
        </tr>
        <tr>
            <td class="lbl">Назив радног места/послова</td>
            <td>{{ $we->job_title }}</td>
        </tr>
        <tr>
            <td class="lbl">Кратак опис посла</td>
            <td>{{ $we->job_description }}</td>
        </tr>
        <tr>
            <td class="lbl">Основ ангажовања</td>
            <td>{{ $employmentBasisLabels[$we->employment_basis] ?? $we->employment_basis }}</td>
        </tr>
        <tr>
            <td class="lbl">Захтевано образовање</td>
            <td>
                @if(!empty($we->required_education))
                    {{ implode('; ', array_map(fn($k) => $requiredEducationLabels[$k] ?? $k, $we->required_education)) }}
                @else
                    —
                @endif
            </td>
        </tr>
    </table>
    @endforeach
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 7. СТРУЧНИ И ДРУГИ ИСПИТИ ─── --}}
<div class="section-title">Стручни и други испити</div>
@if($trainings->isNotEmpty())
<table>
    <tr>
        <th style="width:30%">Врста испита</th>
        <th style="width:15%">Положен испит</th>
        <th style="width:35%">Назив органа/правног лица које је издало доказ</th>
        <th style="width:20%">Дан, месец и година</th>
    </tr>
    @foreach($trainings as $t)
    <tr>
        <td>{{ $t->exam_type }}</td>
        <td>{{ $t->has_certificate ? 'Да' : 'Не' }}</td>
        <td>{{ $t->issuing_authority ?? '—' }}</td>
        <td>{{ $fmt($t->exam_date) }}</td>
    </tr>
    @endforeach
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 8. ЗНАЊЕ СТРАНОГ ЈЕЗИКА ─── --}}
<div class="section-title">Знање страног језика</div>
@if($foreignSkillSet && $foreignSkillSet->foreignLanguageSkills->isNotEmpty())
<table>
    <tr>
        <th style="width:28%">Језик</th>
        <th style="width:22%">Да ли поседујете сертификат</th>
        <th style="width:22%">Ниво (А1, А2, Б1, Б2, Ц1, Ц2)</th>
        <th style="width:15%">Год. полагања</th>
        <th style="width:13%">Ослобађање</th>
    </tr>
    @foreach($foreignSkillSet->foreignLanguageSkills as $lang)
    <tr>
        <td>{{ $lang->foreignLanguage?->language_name ?? '—' }}</td>
        <td>{{ $ynNull($lang->has_certificate) }}</td>
        <td>{{ $lang->level ?? '—' }}</td>
        <td>{{ $lang->year_of_examination ?? '—' }}</td>
        <td>{{ $ynNull($lang->exemption_requested) }}</td>
    </tr>
    @endforeach
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 9. РАД НА РАЧУНАРУ ─── --}}
<div class="section-title">Рад на рачунару</div>
@if($computerSkill)
<table>
    <tr>
        <th style="width:25%">Програм</th>
        <th style="width:45%">Да ли поседујете сертификат/други доказ</th>
        <th style="width:30%">Година стицања сертификата/другог доказа</th>
    </tr>
    <tr>
        <td>Microsoft Word</td>
        <td>{{ $yn($computerSkill->word_has_certificate) }}</td>
        <td>{{ $computerSkill->word_certificate_year ?? '—' }}</td>
    </tr>
    <tr>
        <td>Интернет</td>
        <td>{{ $yn($computerSkill->internet_has_certificate) }}</td>
        <td>{{ $computerSkill->internet_certificate_year ?? '—' }}</td>
    </tr>
    <tr>
        <td>Microsoft Excel</td>
        <td>{{ $yn($computerSkill->excel_has_certificate) }}</td>
        <td>{{ $computerSkill->excel_certificate_year ?? '—' }}</td>
    </tr>
</table>
<table>
    <tr>
        <td class="lbl-wide">Прилажем сертификат ради ослобађања тестирања дигиталне писмености</td>
        <td>
            @if($computerSkill->word_exemption_requested || $computerSkill->excel_exemption_requested || $computerSkill->internet_exemption_requested)
                Да
            @else
                Не
            @endif
        </td>
    </tr>
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 10. ДОДАТНЕ ОБУКЕ ─── --}}
<div class="section-title">Додатне обуке и знања</div>
@if($additionalTrainings->isNotEmpty())
<table>
    <tr>
        <th style="width:30%">Обука / страни језик</th>
        <th style="width:50%">Назив институције и место похађања / Ниво знања страног језика</th>
        <th style="width:20%">Година похађања обуке</th>
    </tr>
    @foreach($additionalTrainings as $at)
    <tr>
        <td>{{ $at->training_name }}</td>
        <td>{{ $at->institution_name }}, {{ $at->location_or_level }}</td>
        <td>{{ $at->year ?? '—' }}</td>
    </tr>
    @endforeach
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 11. ИЗЈАВЕ ─── --}}
<div class="section-title">Изјаве</div>
@if($declaration)

<div class="sub-heading">Ослобађање тестирања општих функционалних компетенција</div>
<table>
    <tr>
        <td class="lbl-wide">Да ли желите да будете ослобођени тестирања општих функционалних компетенција</td>
        <td>{{ $ynNull($declaration->wants_functional_competency_exemption) }}</td>
    </tr>
</table>

<div class="sub-heading">Провера понашајних компетенција</div>
<table>
    <tr>
        <td class="lbl-wide">Да ли вам је у претходне две године вршена провера понашајних компетенција?</td>
        <td>{{ $declaration->behavioral_competency_checked === 'yes' ? 'Да' : ($declaration->behavioral_competency_checked === 'no' ? 'Не' : '—') }}</td>
    </tr>
    @if($declaration->behavioral_competency_checked === 'yes')
    <tr>
        <td class="lbl-wide">Државни орган у ком сте конкурисали</td>
        <td>{{ $declaration->behavioral_competency_checked_body ?? '—' }}</td>
    </tr>
    <tr>
        <td class="lbl-wide">Да ли сте успешно прошли проверу понашајних компетенција?</td>
        <td>{{ $behavioralPassedLabels[$declaration->behavioral_competency_passed] ?? '—' }}</td>
    </tr>
    @endif
</table>

@if($declaration->declarationProofs->isNotEmpty())
<div class="sub-heading">Докази уз пријаву</div>
<table>
    <tr>
        <th style="width:65%">Доказ</th>
        <th>Изјава кандидата</th>
    </tr>
    @foreach($declaration->declarationProofs as $proof)
    <tr>
        <td>{{ $proof->requiredProof?->proof_description ?? '—' }}</td>
        <td>{{ $declarationChoiceLabels[$proof->declaration_choice] ?? ($proof->declaration_choice ?? '—') }}</td>
    </tr>
    @endforeach
</table>
@endif

<div class="sub-heading">Изјава о потреби за посебним условима</div>
<table>
    <tr>
        <td class="lbl-wide">Да ли су вам потребни посебни услови за учешће у провери компетенција</td>
        <td>{{ $ynNull($declaration->special_conditions_needed) }}</td>
    </tr>
    @if($declaration->special_conditions_needed)
    <tr>
        <td class="lbl-wide">Опис посебних услова</td>
        <td>{{ $declaration->special_conditions_description ?? '—' }}</td>
    </tr>
    @endif
</table>

@if($declaration->declarationMinorities->isNotEmpty())
<div class="sub-heading">Добровољна изјава о припадности националној мањини</div>
<table>
    <tr>
        <th style="width:65%">Национална мањина</th>
        <th>Изјава кандидата</th>
    </tr>
    @foreach($declaration->declarationMinorities as $minority)
    <tr>
        <td>{{ $minority->nationalMinority?->minority_name ?? '—' }}</td>
        <td>{{ $minority->choice === 'yes' ? 'Да' : ($minority->choice === 'no' ? 'Не' : '—') }}</td>
    </tr>
    @endforeach
</table>
@endif

<div class="sub-heading">Додатне изјаве</div>
<table>
    <tr>
        <td class="lbl-wide">Да ли вам је у прошлости престајао радни однос у државном органу због теже повреде дужности</td>
        <td>{{ $ynNull($declaration->employment_terminated_for_breach) }}</td>
    </tr>
    <tr>
        <td class="lbl-wide">Начин прибављања података из других службених евиденција</td>
        <td>{{ $officialDataLabels[$declaration->official_data_collection] ?? ($declaration->official_data_collection ?? '—') }}</td>
    </tr>
</table>

@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── 12. ИЗВОР ИНФОРМАЦИЈЕ О КОНКУРСУ ─── --}}
<div class="section-title">Kako сте сазнали за овај конкурс</div>
@if($vacancySource)
<table>
    <tr>
        <td class="lbl">Извор информације</td>
        <td>{{ $sourceLabels[$vacancySource->source] ?? ($vacancySource->source ?? '—') }}</td>
    </tr>
    <tr>
        <td class="lbl">Заинтересован за друге послове у државној управи</td>
        <td>{{ $yn($vacancySource->interested_in_other_jobs) }}</td>
    </tr>
</table>
@else
<div class="note">Подаци нису унети.</div>
@endif

{{-- ─── ПОТПИС ─── --}}
<table class="sig-table" style="margin-top: 18px;">
    <tr>
        <td style="width: 50%;">Место и датум: _______________________________</td>
        <td>Потпис: _______________________________</td>
    </tr>
</table>

</div>
</body>
</html>
