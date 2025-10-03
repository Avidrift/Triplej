<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class TeacherPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('teacher')
            ->path('teacher')
            ->login()
            ->authGuard('teacher')
            ->brandName('TripleJ - Profesor')
            ->colors([
                'primary' => [
                    50 => '248, 245, 255',   // Muy claro
                    100 => '237, 226, 255',  // Claro
                    200 => '221, 198, 255',  // 
                    300 => '196, 155, 255',  //
                    400 => '167, 104, 255',  //
                    500 => '139, 69, 255',   // Base - púrpura vibrante
                    600 => '124, 58, 237',   // 
                    700 => '109, 48, 219',   //
                    800 => '88, 40, 181',    //
                    900 => '70, 35, 143',    // Muy oscuro
                    950 => '48, 25, 92',     // Más oscuro
                ],
            ])
            ->discoverResources(in: app_path('Filament/Teacher/Resources'), for: 'App\\Filament\\Teacher\\Resources')
            ->discoverPages(in: app_path('Filament/Teacher/Pages'), for: 'App\\Filament\\Teacher\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Teacher/Widgets'), for: 'App\\Filament\\Teacher\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->resources([
                \App\Filament\Resources\LiteracyHourResource::class,
                \App\Filament\Resources\StudentResource::class,
                \App\Filament\Resources\TeacherResource::class,
                \App\Filament\Resources\CertificateResource::class,
                // Agrega aquí otros recursos que el maestro debe ver
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
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}