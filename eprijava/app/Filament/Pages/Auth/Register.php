<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\RegistrationResponse;
use Filament\Auth\Events\Registered;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Auth\Pages\Register as BaseRegister;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class Register extends BaseRegister
{
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
            $this->getPasswordConfirmationFormComponent(),
        ]);
    }

    protected function handleRegistration(array $data): Model
    {
        $user = $this->getUserModel()::create($data);
        $user->assignRole('kandidat');
        $user->toggleEmailAuthentication(true);

        return $user;
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();
        $data = $this->mutateFormDataBeforeRegister($data);

        $user = $this->handleRegistration($data);

        $this->form->model($user)->saveRelationships();

        event(new Registered($user));

        Notification::make()
            ->title('Nalog je uspešno kreiran. Prijavite se.')
            ->success()
            ->send();

        $this->redirect(Filament::getLoginUrl());

        return null;
    }
}
