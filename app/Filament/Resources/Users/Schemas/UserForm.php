<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\GovernmentBody;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('government_body_id')
                    ->label('Државни орган')
                    ->options(GovernmentBody::query()->pluck('name', 'id'))
                    ->searchable()
                    ->nullable(),
                TextInput::make('email')
                    ->label('Адреса е-поште')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => filled($state) ? bcrypt($state) : null)
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->label(fn (string $operation): string => $operation === 'create' ? 'Лозинка' : 'Нова лозинка (оставите празно за исту лозинку)'),
                Select::make('roles')
                    ->label('Улоге')
                    ->multiple()
                    ->relationship('roles', 'name')
                    ->options(Role::query()->pluck('name', 'id'))
                    ->preload()
                    ->searchable(),
            ]);
    }
}
