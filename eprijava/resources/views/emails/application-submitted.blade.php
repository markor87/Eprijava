<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; color: #333; line-height: 1.6; }
        .content { max-width: 650px; margin: 0 auto; padding: 20px; }
        .code { font-weight: bold; }
    </style>
</head>
<body>
    <div class="content">
        <p>Поштовани/а {{ $user->name }},</p>

        <p>Поводом Ваше пријаве на {{ mb_strtolower($jobPosition->competition?->tip_konkursa) }} конкурс у органу: {{ $jobPosition->governmentBody?->name }} и за попуњавање радног места, радно место под редним бројем {{ $jobPosition->sequence_number }}: {{ $jobPosition->position_name }}, у звању {{ $jobPosition->rank?->name }}, са седиштем {{ $jobPosition->workLocation?->name }}, обавештавамо Вас да је пријави додељена шифра: <span class="code">{{ $application?->candidate_code }}</span>.</p>

        <p>Сагласно члану 15. Уредбе о интерном и јавном конкурсу за попуњавање радних места у државним органима („Сл. гласник РС", бр. 2/19, 67/21), приликом предаје пријаве на конкурс, пријава добија шифру под којом подносилац пријаве учествује у даљем изборном поступку, па је потребно да је чувате, с тога Вас молимо да исту имате код себе приликом тестирања.</p>

        <p>Свака поднета пријава, без обзира да ли је исправна или не, добија шифру.</p>

        <p>Срдачан поздрав,<br>
        {{ $jobPosition->governmentBody?->name }}</p>
    </div>
</body>
</html>
