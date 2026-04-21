<?php

namespace App\Listeners;

use App\Models\LoginLog;
use App\Models\Setting;
use App\Notifications\SuspiciousLoginAlert;
use Illuminate\Auth\Events\Failed;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Cache;

class LogFailedLogin
{
    // Filament fires Failed once per guard per request; deduplicate so we count one attempt.
    private static array $handledEmails = [];

    public function handle(Failed $event): void
    {
        $ip    = request()->ip();
        $email = $event->credentials['email'] ?? '';

        if (in_array($email, self::$handledEmails, true)) {
            return;
        }
        self::$handledEmails[] = $email;

        LoginLog::create([
            'user_id'        => $event->user?->id,
            'email'          => $email,
            'ip_address'     => $ip,
            'user_agent'     => request()->userAgent(),
            'success'        => false,
            'failure_reason' => 'bad_credentials',
        ]);

        if (Setting::get('alert_failed_attempts', '1') !== '1') {
            return;
        }

        $alertEmail = config('app.security_alert_email');
        if (!$alertEmail) {
            return;
        }

        $countKey = 'login_failed_' . md5($email);
        Cache::add($countKey, 0, now()->addMinutes(10));
        $count = Cache::increment($countKey);

        if ($count === 10) {
            (new AnonymousNotifiable)
                ->route('mail', $alertEmail)
                ->notify(new SuspiciousLoginAlert('failed_attempts', [
                    'email'         => $email,
                    'ip'            => $ip,
                    'attempt_count' => $count,
                ]));
        }
    }
}
