<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ForeignLanguageSkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Страни језик')
                ->schema([
                    TextInput::make('language')
                        ->label('Страни језик')
                        ->required(),
                    Select::make('level')
                        ->label('Ниво')
                        ->options([
                            'А1' => 'А1',
                            'А2' => 'А2',
                            'Б1' => 'Б1',
                            'Б2' => 'Б2',
                            'Ц1' => 'Ц1',
                            'Ц2' => 'Ц2',
                        ])
                        ->required(),
                    Select::make('has_certificate')
                        ->label('Поседујем сертификат')
                        ->options([
                            1 => 'Да',
                            0 => 'Не',
                        ])
                        ->required(),
                    TextInput::make('year_of_examination')
                        ->label('Година полагања')
                        ->numeric(),
                    Select::make('exemption_requested')
                        ->label('Прилажем сертификат ради ослобађања тестирања')
                        ->options([
                            1 => 'Да',
                            0 => 'Не',
                        ])
                        ->required()
                        ->columnSpanFull(),
                    FileUpload::make('certificate_attachment')
                        ->label('Прилог сертификата')
                        ->disk('public')
                        ->directory(fn() => 'certificate-attachments/' . auth()->id())
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }
}
