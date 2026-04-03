<?php

namespace App\Filament\Resources\Trainings\Schemas;

use App\Models\ExamType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TrainingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Стручни и други испити')
                ->inlineLabel()
                ->schema([
                    Repeater::make('trainings')
                        ->relationship('trainings')
                        ->label('')
                        ->addable(false)
                        ->deletable(false)
                        ->reorderable(false)
                        ->schema([
                            Hidden::make('exam_type_id'),
                            TextEntry::make('exam_type_label')
                                ->label('Врста испита')
                                ->state(fn($get) => ExamType::find($get('exam_type_id'))?->name ?? '—'),
                            Select::make('has_certificate')
                                ->label('Да ли поседујете сертификат')
                                ->options([1 => 'Да', 0 => 'Не'])
                                ->live()
                                ->afterStateUpdated(function ($state, $set) {
                                    if ($state == 0) {
                                        $set('issuing_authority', null);
                                        $set('exam_date', null);
                                    }
                                }),
                            TextInput::make('issuing_authority')
                                ->label('Назив органа / правног лица које је издало доказ')
                                ->hidden(fn($get) => !$get('has_certificate'))
                                ->required(fn($get) => (bool) $get('has_certificate'))
                                ->extraInputAttributes(['novalidate' => true, 'required' => false])
                                ->validationMessages(['required' => 'Поље назив органа је обавезно.']),
                            DatePicker::make('exam_date')
                                ->label('Датум похађања')
                                ->native(false)
                                ->displayFormat('d.m.Y')
                                ->hidden(fn($get) => !$get('has_certificate'))
                                ->required(fn($get) => (bool) $get('has_certificate')),
                        ]),
                ]),
        ]);
    }
}
