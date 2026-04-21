<?php

namespace App\Listeners;

use App\Models\LoginLog;
use App\Models\Setting;
use App\Notifications\SuspiciousLoginAlert;
use Illuminate\Auth\Events\Login;
use Illuminate\Notifications\AnonymousNotifiable;
use Stevebauman\Location\Facades\Location;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        $ip = request()->ip();

        if (in_array($ip, ['127.0.0.1', '::1']) || $this->isPrivateIp($ip)) {
            return;
        }

        $position   = Location::get($ip);
        $countryCode = $position?->countryCode;
        $city        = $position?->cityName;
        $user        = $event->user;

        LoginLog::create([
            'user_id'      => $user->id,
            'email'        => $user->email,
            'ip_address'   => $ip,
            'country_code' => $countryCode,
            'city'         => $city,
            'user_agent'   => request()->userAgent(),
            'success'      => true,
        ]);

        $alertEmail = config('app.security_alert_email');
        if (!$alertEmail) {
            return;
        }

        $context = [
            'email'        => $user->email,
            'ip'           => $ip,
            'country_code' => $countryCode,
            'city'         => $city,
        ];

        if (Setting::get('alert_foreign_login', '1') === '1'
            && $position && $countryCode !== 'RS'
        ) {
            (new AnonymousNotifiable)
                ->route('mail', $alertEmail)
                ->notify(new SuspiciousLoginAlert('foreign_country', $context));
        }

        if (Setting::get('alert_new_ip', '1') === '1') {
            $stats = LoginLog::where('user_id', $user->id)->where('success', true)
                ->selectRaw('COUNT(*) as total, SUM(CASE WHEN ip_address = ? THEN 1 ELSE 0 END) as from_this_ip', [$ip])
                ->first();

            // total > 1 because we just inserted this login; from_this_ip === 1 means brand new IP
            if (($stats->total ?? 0) > 1 && ($stats->from_this_ip ?? 0) == 1) {
                (new AnonymousNotifiable)
                    ->route('mail', $alertEmail)
                    ->notify(new SuspiciousLoginAlert('new_ip', $context));
            }
        }
    }

    private function isPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }
}
