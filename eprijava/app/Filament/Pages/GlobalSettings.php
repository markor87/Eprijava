<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use UnitEnum;

class GlobalSettings extends Page
{
    protected static string|BackedEnum|null $navigationIcon  = 'heroicon-o-cog-6-tooth';
    protected static string|UnitEnum|null   $navigationGroup = 'Администрација';
    protected static ?int                   $navigationSort  = 99;

    public static function getNavigationLabel(): string
    {
        return 'Подешавања';
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'two_factor_required' => (bool) Setting::get('two_factor_required', '1'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Toggle::make('two_factor_required')
                    ->label('Двофакторска аутентификација')
                    ->helperText('Када је укључена, сви корисници морају да потврде пријаву путем е-поште.')
                    ->onIcon('heroicon-m-shield-check')
                    ->offIcon('heroicon-m-shield-exclamation'),
            ])
            ->statePath('data');
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make($this->getFormActions())->key('form-actions'),
                ]),
        ]);
    }

    public function save(): void
    {
        Setting::set('two_factor_required', $this->data['two_factor_required'] ? '1' : '0');

        Notification::make()
            ->title('Подешавање сачувано')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Сачувај')
                ->submit('save'),
        ];
    }
}
