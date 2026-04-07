<?php

namespace App\Providers\Filament;

use App\Models\Setting;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $twoFactorEnabled = true;
        try {
            $twoFactorEnabled = (bool) Setting::get('two_factor_required', '1');
        } catch (\Throwable) {}

        $panel = $panel
            ->default()
            ->id('app')
            ->path('app')
            ->brandName('Е-пријава')
            ->login()
            ->registration(\App\Filament\Pages\Auth\Register::class);

        if ($twoFactorEnabled) {
            $panel->multiFactorAuthentication([
                EmailAuthentication::make()
                    ->codeExpiryMinutes(5)
                    ->codeNotification(\App\Notifications\VerifyEmailAuthentication::class),
            ], isRequired: true);
        }

        return $panel
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->plugins([
                FilamentShieldPlugin::make(),
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE,
                fn () => new HtmlString('
                    <div style="display:flex; align-items:center; justify-content:center; gap:1.5rem; margin-bottom:1.5rem; flex-wrap:wrap;">
                        <img src="/images/poreska-uprava.jpg" alt="Пореска управа" style="height:70px; border-radius:6px;">
                        <img src="/images/suk-logo.png" alt="Служба за управљање кадровима" style="height:70px;">
                    </div>
                '),
            )
            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn () => Auth::check()
                    ? new HtmlString('<div style="padding: 0 1rem; font-size: 0.75rem; color: #6b7280; white-space: nowrap;">Ваш идентификациони број је: <strong>' . Auth::id() . '</strong></div>')
                    : new HtmlString(''),
            );
    }
}
