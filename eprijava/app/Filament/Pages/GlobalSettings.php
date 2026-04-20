<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Schemas\Components\Section;
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
            'two_factor_required'  => (bool) Setting::get('two_factor_required', '1'),
            'alert_foreign_login'  => (bool) Setting::get('alert_foreign_login', '1'),
            'alert_new_ip'         => (bool) Setting::get('alert_new_ip', '1'),
            'alert_failed_attempts'=> (bool) Setting::get('alert_failed_attempts', '1'),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Аутентификација')
                    ->schema([
                        Toggle::make('two_factor_required')
                            ->label('Двофакторска аутентификација')
                            ->helperText('Када је укључена, сви корисници морају да потврде пријаву путем е-поште.')
                            ->onIcon('heroicon-m-shield-check')
                            ->offIcon('heroicon-m-shield-exclamation'),
                    ]),

                Section::make('Безбедносна упозорења')
                    ->description('Упозорења се шаљу на адресу из подешавања сервера (SECURITY_ALERT_EMAIL).')
                    ->schema([
                        Toggle::make('alert_foreign_login')
                            ->label('Пријава из иностранства')
                            ->helperText('Шаље е-маил ако се неко пријави са IP адресе ван Србије.'),

                        Toggle::make('alert_new_ip')
                            ->label('Пријава са нове IP адресе')
                            ->helperText('Шаље е-маил кад се корисник пријави са IP адресе коју раније није користио.'),

                        Toggle::make('alert_failed_attempts')
                            ->label('Вишеструки неуспешни покушаји')
                            ->helperText('Шаље е-маил ако исти налог 10 пута неуспешно покуша да се пријави за 10 минута.'),
                    ]),
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
        Setting::set('two_factor_required',   $this->data['two_factor_required']   ? '1' : '0');
        Setting::set('alert_foreign_login',   $this->data['alert_foreign_login']   ? '1' : '0');
        Setting::set('alert_new_ip',          $this->data['alert_new_ip']          ? '1' : '0');
        Setting::set('alert_failed_attempts', $this->data['alert_failed_attempts'] ? '1' : '0');

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
