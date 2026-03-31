<?php

namespace App\Filament\Resources\ForeignLanguageSkills\Schemas;

use App\Models\ForeignLanguage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ForeignLanguageSkillForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Страни језик')
                ->description('Напомена: Ако поседујете важећи сертификат, потврду или други доказ који је тражен у конкурсном поступку и желите да на основу њега будете ослобођени тестирања компетенције знање страног језика, неопходно је да доставите и тражени доказ у оригиналу или овереној фотокопији. Комисија ће на основу приложеног доказа донети одлуку да ли може или не може да прихвати доказ који сте приложили уместо писмене/усмене провере. Сертификат је неопходно приложити на увид на дан тестирања.')
                ->inlineLabel()
                ->schema([
                    Repeater::make('foreignLanguageSkills')
                        ->relationship('foreignLanguageSkills')
                        ->label('')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->schema([
                            Hidden::make('foreign_language_id'),
                            TextEntry::make('language_label')
                                ->label('Страни језик')
                                ->state(fn($get) => ForeignLanguage::find($get('foreign_language_id'))?->language_name ?? '—'),
                            Select::make('level')
                                ->label('Ниво')
                                ->options([
                                    'А1' => 'А1',
                                    'А2' => 'А2',
                                    'Б1' => 'Б1',
                                    'Б2' => 'Б2',
                                    'Ц1' => 'Ц1',
                                    'Ц2' => 'Ц2',
                                ]),
                            Select::make('has_certificate')
                                ->label('Поседујем сертификат')
                                ->options([1 => 'Да', 0 => 'Не']),
                            TextInput::make('year_of_examination')
                                ->label('Година полагања')
                                ->numeric(),
                            Select::make('exemption_requested')
                                ->label('Прилажем сертификат ради ослобађања тестирања')
                                ->options([1 => 'Да', 0 => 'Не']),
                        ]),
                    FileUpload::make('certificate_attachment')
                        ->label('Прилог сертификата')
                        ->multiple()
                        ->disk('public')
                        ->directory(fn() => 'certificate-attachments/' . auth()->user()?->id),
                ]),
        ]);
    }
}
