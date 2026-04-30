<?php

namespace App\Notifications;

use Filament\Auth\MultiFactor\Email\Notifications\VerifyEmailAuthentication as BaseNotification;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailAuthentication extends BaseNotification
{
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Е-пријава двофакторска аутентификација')
            ->greeting('Покушавате да се пријавите на портал Е-пријаве.')
            ->line('Ваш код за пријаву је: **' . $this->code . '**')
            ->line('Уколико то нисте били Ви, молимо Вас да контактирате Пореску управу на ' . env('CONTACT_EMAIL') . '.')
            ->line('Овај код истиче за ' . ($this->codeExpiryMinutes === 1 ? 'минут' : $this->codeExpiryMinutes . ' минута') . '.')
            ->salutation('Срдачан поздрав,<br>Пореска управа');
    }
}
