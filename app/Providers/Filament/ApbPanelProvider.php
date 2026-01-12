<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\ApbAgendaWidget;
use Guava\Calendar\CalendarPlugin;
use App\Models\AdminSetting;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Actions\Action;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Joaopaulolndev\FilamentEditProfile\FilamentEditProfilePlugin;
use Joaopaulolndev\FilamentEditProfile\Pages\EditProfilePage;
use Illuminate\Support\Facades\DB;

class ApbPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $settings = null;
        try {
            if (!app()->runningInConsole()) {
                $settings = DB::table('admin_settings')->first();
            }
        } catch (\Throwable $e) {}

        $panel = $panel
            ->default()
            ->id('apb')
            ->path('apb')
            ->login()
            ->brandName($settings?->brand_name ?? 'APB Dashboard')
            ->homeUrl('/')
            ->font($settings?->font_family ?? 'Inter');
        if ($settings?->logo_path) {
            $panel->brandLogo(asset('storage/' . $settings->logo_path));
        }

        if ($settings?->favicon_path) {
            $panel->favicon(asset('storage/' . $settings->favicon_path));
        }

        if ($settings?->primary_color) {
            $panel->colors([
                'danger' => $settings->danger_color ?? Color::Rose,
                'gray' => Color::Gray,
                'info' => $settings->primary_color,
                'primary' => $settings->primary_color ?? Color::Cyan,
                'success' => $settings->success_color ?? Color::Teal,
                'warning' => $settings->warning_color ?? Color::Amber,
            ]);
        }

        $panel->renderHook(
            PanelsRenderHook::HEAD_END,
            function () use ($settings): string {
                if (!$settings) return '';

                $primaryHex = $settings->primary_color ?? '#f59e0b';
                $grayHex = $settings->gray_color ?? '#09090b';
                $bgHex = $settings->background_color ?? '#000000';
                $sidebarHex = $settings->sidebar_color ?? '#111111';

                // On génère une couleur de bordure subtile basée sur le gris
                $borderColor = "rgba(255, 255, 255, 0.1)";

                return "
                <style>
                    :root, .dark {
                        --primary-500: {$primaryHex} !important;
                        --primary-600: {$primaryHex} !important;
                        /* Supprime le halo bleu au focus */
                        --tw-ring-color: transparent !important;
                    }

                    /* 1. TOPBAR (La barre du haut qui était restée mauve/bleue) */
                    .fi-topbar {
                        background-color: {$bgHex} !important;
                        border-bottom: 1px solid {$borderColor} !important;
                    }
                    .fi-topbar nav {
                        background-color: transparent !important;
                    }

                    /* 2. SIDEBAR (Navigation latérale) */
                    .fi-sidebar {
                        background-color: {$sidebarHex} !important;
                        border-right: 1px solid {$borderColor} !important;
                    }

                    /* Texte des menus : Toujours blanc/gris clair pour la lisibilité */
                    .dark .fi-sidebar-item-label,
                    .dark .fi-sidebar-group-label {
                        color: rgba(255, 255, 255, 0.7) !important;
                    }

                    /* Item actif : Prend la couleur primaire */
                    .dark .fi-sidebar-item-active .fi-sidebar-item-label,
                    .dark .fi-sidebar-item-active .fi-sidebar-item-icon {
                        color: {$primaryHex} !important;
                    }

                    /* 3. CONTENU ET SECTIONS (Les boîtes qui étaient bleues) */
                    body.fi-body {
                        background-color: {$bgHex} !important;
                    }

                    .fi-main {
                        background-color: {$bgHex} !important;
                    }

                    /* Cible les cartes, sections et widgets */
                    .dark .fi-section,
                    .dark .fi-card,
                    .dark .fi-ta-ctn,
                    .dark .fi-wi-widget > div {
                        background-color: {$grayHex} !important;
                        border: 1px solid {$borderColor} !important;
                        box-shadow: none !important;
                    }

                    /* En-têtes des sections */
                    .dark .fi-section-header-heading {
                        color: white !important;
                    }

                    /* 4. TABLES ET BOUTONS FILTRES */
                    .dark .fi-ta-header-toolbar {
                        background-color: transparent !important;
                    }

                    /* Boutons d'action (comme 'Appliquer les filtres') */
                    .fi-btn-color-primary {
                        background-color: {$primaryHex} !important;
                    }

                    /* Notifications Toasts */
                    .fi-no-notification {
                        background-color: {$grayHex} !important;
                        border: 1px solid {$primaryHex} !important;
                    }
                </style>
                ";
            }
        );

        return $panel
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([Dashboard::class])
            ->widgets([
                AccountWidget::class,
                ApbAgendaWidget::class,
            ])
            ->navigationItems([
                NavigationItem::make('Retour sur le site')
                    ->url(fn() => route('accueil'))
                    ->openUrlInNewTab()
                    ->icon(Heroicon::Power)
            ])
            ->plugins([
                FilamentShieldPlugin::make()->navigationGroup('Paramètres'),
                FilamentEditProfilePlugin::make()
                    ->slug('my-profile')
                    ->setTitle('My Profile')
                    ->setNavigationLabel('My Profile')
                    ->setNavigationGroup('Group Profile')
                    ->setIcon('heroicon-o-user')
                    ->setSort(10)
                    ->shouldRegisterNavigation(false)
                    ->shouldShowEmailForm()
                    ->shouldShowDeleteAccountForm(false)
                    ->shouldShowSanctumTokens()
                    ->shouldShowBrowserSessionsForm()
                    ->shouldShowAvatarForm(),

            ])
            ->userMenuItems([
                'profile' => Action::make('profile')
                    ->label(fn() => auth()->user()->firstname)
                    ->url(fn (): string => EditProfilePage::getUrl())
                    ->icon('heroicon-m-user-circle')
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
            ->authMiddleware([Authenticate::class]);
    }
}

// Fonction utilitaire
function hexToRgb($hex) {
    $hex = str_replace("#", "", $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    return "$r, $g, $b";
}
