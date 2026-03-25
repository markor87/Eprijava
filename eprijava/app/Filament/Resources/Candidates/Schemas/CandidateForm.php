<?php

namespace App\Filament\Resources\Candidates\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Лични подаци')
                ->inlineLabel()
                ->schema([
                    TextInput::make('first_name')
                        ->label('Име')
                        ->required(),
                    TextInput::make('last_name')
                        ->label('Презиме')
                        ->required(),
                    TextInput::make('national_id')
                        ->label('Матични број (ЈМБГ)')
                        ->required()
                        ->length(13),
                    TextInput::make('citizenship')
                        ->label('Држављанство')
                        ->required(),
                    TextInput::make('place_of_birth')
                        ->label('Место рођења')
                        ->required()
,
                ])
                ,

            Section::make('Адреса пребивалишта')
                ->inlineLabel()
                ->description('Наведите адресу на коју орган може да вам доставља обавештења/решења у изборном поступку, ако није иста као адреса пребивалишта')
                ->schema([
                    TextInput::make('address_street')
                        ->label('Улица и број')
                        ->required()
,
                    TextInput::make('address_postal_code')
                        ->label('Поштански број')
                        ->required(),
                    TextInput::make('address_city')
                        ->label('Место')
                        ->required(),
                ])
                ,

            Section::make('Адреса за доставу')
                ->inlineLabel()
                ->description('Оставити празно ако је иста као адреса пребивалишта.')
                ->schema([
                    TextInput::make('delivery_street')
                        ->label('Улица и број')
,
                    TextInput::make('delivery_postal_code')
                        ->label('Поштански број'),
                    TextInput::make('delivery_city')
                        ->label('Место'),
                    Textarea::make('other_delivery_methods')
                        ->label('Наведите податке за остале начине доставе обавештења')
                        ->rows(3)
,
                ])
                ,

            Section::make('Контакт')
                ->inlineLabel()
                ->description('Напомена: Број телефона и Е-адреса су обавезне рубрике за попуњавање. За потребе пријављивања на конкурсе у државним органима, потребно је да имате отворену Е-адресу за примање електронске поште. Пријаве које не садрже унету Е-адресу и број телефона ће бити одбачене.')
                ->schema([
                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->required(),
                    TextInput::make('email')
                        ->label('Е-пошта')
                        ->email()
                        ->required(),
                ])
                ,

            Section::make('Остало')
                ->inlineLabel()
                ->schema([
                    Textarea::make('alternative_delivery')
                        ->label('Други начин на који могу да вам се достављају обавештења')
                        ->rows(3)
,
                ]),
        ]);
    }
}
