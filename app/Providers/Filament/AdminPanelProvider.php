<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Support\Enums\Width;
use Filament\Support\Colors\Color;
use Spatie\Permission\Models\Role;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use App\Filament\Widgets\LoanChartWidget;
use App\Filament\Widgets\AdminStatsWidget;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Widgets\StudentStatsWidget;
use Illuminate\Session\Middleware\StartSession;
use App\Filament\Widgets\TopBorrowedBooksWidget;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('')
            ->registration()
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->maxContentWidth(Width::Full)
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                // AccountWidget::class,
                // FilamentInfoWidget::class,
                AdminStatsWidget::class,
                StudentStatsWidget::class,
                LoanChartWidget::class,
                TopBorrowedBooksWidget::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->navigationLabel('Role Management')
                    ->navigationIcon('heroicon-o-home')
                    ->activeNavigationIcon('heroicon-s-home')
                    ->navigationGroup('Master Data')
                    ->navigationSort(10)
                    ->navigationBadge(Role::count())
                    ->navigationBadgeColor('success'),
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
            ])
            ->spa();
    }
}
