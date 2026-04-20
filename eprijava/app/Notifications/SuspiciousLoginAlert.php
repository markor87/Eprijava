<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SuspiciousLoginAlert extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private string $type,
        private array $context
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $ctx = $this->context;
        $time = now()->format('d.m.Y. H:i:s');

        return match ($this->type) {
            'foreign_country' => (new MailMessage)
                ->subject('Упозорење: пријава са стране земље')
                ->greeting('Откривена сумњива активност')
                ->line('Корисник **' . $ctx['email'] . '** пријавио се са IP адресе ван Србије.')
                ->line('**IP адреса:** ' . $ctx['ip'])
                ->line('**Земља:** ' . ($ctx['country_code'] ?? 'непозната') . ($ctx['city'] ? ' (' . $ctx['city'] . ')' : ''))
                ->line('**Време:** ' . $time)
                ->salutation('Е-пријава систем'),

            'new_ip' => (new MailMessage)
                ->subject('Упозорење: пријава са нове IP адресе')
                ->greeting('Откривена нова IP адреса')
                ->line('Корисник **' . $ctx['email'] . '** пријавио се са IP адресе коју раније није користио.')
                ->line('**IP адреса:** ' . $ctx['ip'])
                ->line('**Локација:** ' . ($ctx['city'] ?? 'непознато'))
                ->line('**Време:** ' . $time)
                ->salutation('Е-пријава систем'),

            'failed_attempts' => (new MailMessage)
                ->subject('Упозорење: вишеструки неуспешни покушаји пријаве')
                ->greeting('Могући покушај неовлашћеног приступа')
                ->line('Налог **' . $ctx['email'] . '** имао је ' . ($ctx['attempt_count'] ?? 10) . ' неуспешних покушаја пријаве за кратко време.')
                ->line('**IP адреса:** ' . $ctx['ip'])
                ->line('**Време:** ' . $time)
                ->salutation('Е-пријава систем'),

            default => (new MailMessage)->subject('Упозорење')->line('Сумњива активност откривена.'),
        };
    }
}
