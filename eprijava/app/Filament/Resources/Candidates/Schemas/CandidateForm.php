<?php

namespace App\Filament\Resources\Candidates\Schemas;

use App\Models\Place;
use App\Rules\Jmbg;
use App\Rules\SerbianCyrillic;
use Filament\Forms\Components\Select;
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
                        ->rule(new SerbianCyrillic())
                        ->required(),
                    TextInput::make('last_name')
                        ->label('Презиме')
                        ->rule(new SerbianCyrillic())
                        ->required(),
                    TextInput::make('national_id')
                        ->label('Матични број (ЈМБГ)')
                        ->required()
                        ->maxLength(13)
                        ->rule(new Jmbg()),
                    Select::make('citizenship')
                        ->label('Држављанство')
                        ->options([
                            'српско' => 'Српско',
                            'остало' => 'Остало',
                        ])
                        ->required(),
                    Select::make('place_of_birth_id')
                        ->label('Место рођења')
                        ->getSearchResultsUsing(fn(string $search) =>
                            Place::query()
                                ->where('name', 'like', "%{$search}%")
                                ->orderBy('name')
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn($p) => [$p->id => $p->name . ' (' . $p->municipality_name . ')'])
                                ->toArray()
                        )
                        ->getOptionLabelUsing(fn($value) =>
                            ($p = Place::find($value)) ? $p->name . ' (' . $p->municipality_name . ')' : $value
                        )
                        ->searchable()
                        ->required(),
                ])
                ,

            Section::make('Адреса пребивалишта')
                ->inlineLabel()
                ->description('Наведите адресу на коју орган може да вам доставља обавештења/решења у изборном поступку, ако није иста као адреса пребивалишта')
                ->schema([
                    TextInput::make('address_street')
                        ->label('Улица и број')
                        ->rule(new SerbianCyrillic())
                        ->required(),
                    TextInput::make('address_postal_code')
                        ->label('Поштански број')
                        ->regex('/^[123]\d{4}$/')
                        ->required(),
                    Select::make('address_city')
                        ->label('Место')
                        ->getSearchResultsUsing(fn(string $search) =>
                            Place::query()
                                ->where('name', 'like', "%{$search}%")
                                ->orderBy('name')
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn($p) => [$p->id => $p->name . ' (' . $p->municipality_name . ')'])
                                ->toArray()
                        )
                        ->getOptionLabelUsing(fn($value) =>
                            ($p = Place::find($value)) ? $p->name . ' (' . $p->municipality_name . ')' : $value
                        )
                        ->searchable()
                        ->required(),
                ])
                ,

            Section::make('Адреса за доставу')
                ->inlineLabel()
                ->description('Оставити празно ако је иста као адреса пребивалишта.')
                ->schema([
                    TextInput::make('delivery_street')
                        ->label('Улица и број')
                        ->rule(new SerbianCyrillic()),
                    TextInput::make('delivery_postal_code')
                        ->label('Поштански број')
                        ->regex('/^[123]\d{4}$/'),
                    Select::make('delivery_city')
                        ->label('Место')
                        ->getSearchResultsUsing(fn(string $search) =>
                            Place::query()
                                ->where('name', 'like', "%{$search}%")
                                ->orderBy('name')
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn($p) => [$p->id => $p->name . ' (' . $p->municipality_name . ')'])
                                ->toArray()
                        )
                        ->getOptionLabelUsing(fn($value) =>
                            ($p = Place::find($value)) ? $p->name . ' (' . $p->municipality_name . ')' : $value
                        )
                        ->searchable(),
                    Textarea::make('other_delivery_methods')
                        ->label('Наведите податке за остале начине доставе обавештења')
                        ->rule(new SerbianCyrillic())
                        ->rows(3),
                ])
                ,

            Section::make('Контакт')
                ->inlineLabel()
                ->description('Напомена: Број телефона и Е-адреса су обавезне рубрике за попуњавање. За потребе пријављивања на конкурсе у државним органима, потребно је да имате отворену Е-адресу за примање електронске поште. Пријаве које не садрже унету Е-адресу и број телефона ће бити одбачене.')
                ->schema([
                    TextInput::make('phone')
                        ->label('Телефон')
                        ->tel()
                        ->regex('/^(\+381|0)[1-9][\d\s\-]{6,10}$/')
                        ->helperText('Пример: 063 123 4567 или +381 63 123 4567')
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
                        ->rule(new SerbianCyrillic())
                        ->rows(3),
                ]),
        ]);
    }
}
