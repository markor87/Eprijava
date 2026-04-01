<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <p>Поштовани/а {{ $user->name }},</p>

    <p>Ваша пријава на конкурс за радно место <strong>{{ $jobPosition->position_name }}</strong> је успешно поднета.</p>

    <p>Можете да прегледате своје пријаве у систему у одељку <strong>Мој профил → Поднете пријаве</strong>.</p>

    <p>Са поштовањем,<br>{{ config('app.name') }}</p>
</body>
</html>
