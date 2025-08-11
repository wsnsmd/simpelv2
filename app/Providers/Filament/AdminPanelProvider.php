<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\EmailVerification;
use App\Filament\Pages\Auth\Login;
// use App\Filament\Pages\Auth\RequestPasswordReset;
use App\Filament\Resources\MenuResource;
use App\Livewire\MyProfileExtended;
use App\Settings\GeneralSettings;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Widgets;
use Filament\Support\Enums\MaxWidth;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\View\View;
use PhpParser\Node\Stmt\Label;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $listenModalLoading = [
            '__dispatch',
            'activeTab',
            'changeTab',
            'gotoPage',
            'nextPage',
            'previousPage',
            'sortTable',
            'tableRecordsPerPage',
            'removeTableFilter',
            'tableGrouping',
            'tableGroupingDirection',
            'toggledTableColumns',
            'tableSearch',
            'tableFilters',
            'resetTableSearch',
            'mountTableAction',
            'mountFormComponentAction',
            'mountedActionsData',
        ];

        return $panel
            ->default()
            ->id('admin')
            ->path('v2/admin')
            ->login(Login::class)
            ->maxContentWidth(MaxWidth::Full)
            ->favicon(fn (GeneralSettings $settings) => Storage::url($settings->site_favicon))
            ->brandName(fn (GeneralSettings $settings) => $settings->brand_name)
            ->brandLogo(fn (GeneralSettings $settings) => Storage::url($settings->brand_logo))
            ->brandLogoHeight(fn (GeneralSettings $settings) => $settings->brand_logoHeight)
            ->colors(fn (GeneralSettings $settings) => $settings->site_theme)
            ->font('DM Sans')
            ->databaseNotifications()->databaseNotificationsPolling('30s')
            ->globalSearch(false)
            // ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->sidebarWidth('16rem')
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                Navigation\NavigationGroup::make()
                    ->label(__('Data'))
                    ->collapsed(),
                Navigation\NavigationGroup::make()
                    ->label(__('Laporan'))
                    ->collapsed(),
                Navigation\NavigationGroup::make()
                    ->label('Content')
                    ->collapsible(false),
                Navigation\NavigationGroup::make()
                    ->label(__('menu.nav_group.access'))
                    ->collapsible(false),
                Navigation\NavigationGroup::make()
                    ->label(__('menu.nav_group.settings'))
                    ->collapsed(),
                Navigation\NavigationGroup::make()
                    ->label(__('menu.nav_group.activities'))
                    ->collapsed(),
            ])
            ->navigationItems([
                Navigation\NavigationItem::make('Log Viewer')
                    ->visible(fn(): bool => auth()->user()->can('access_log_viewer'))
                    ->url(config('app.url').'/'.config('log-viewer.route_path'), shouldOpenInNewTab: true)
                    ->icon('fluentui-document-bullet-list-multiple-20-o')
                    ->group(__('menu.nav_group.activities'))
                    ->sort(99),
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->renderHook('panels::styles.before', fn(): string => Blade::render(<<<'HTML'
                <style>
                    /** Setting Base Font */
                    html, body{
                        font-size: 14px;
                    }
                </style>
            HTML))
            ->renderHook(PanelsRenderHook::GLOBAL_SEARCH_AFTER, fn () => view('components.select-tahun'))
            // ->renderHook(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE, fn(): View => view('components.total-records'))
            ->renderHook(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER, fn(): string => Blade::render(<<<'HTML'
                <x-modal-loading wire:loading wire:target="{{ $target }}" />
            HTML, [
                'target' => implode(',', $listenModalLoading),
            ]))
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn(): string => Blade::render('
                    <x-wire-modal-loading />
                '),
            )
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->resources([
                config('filament-logger.activity_resource')
            ])
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\FilamentInfoWidget::class,
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
            ->plugins([
                \TomatoPHP\FilamentMediaManager\FilamentMediaManagerPlugin::make()
                    ->allowSubFolders(),
                \BezhanSalleh\FilamentExceptions\FilamentExceptionsPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
                    ->gridColumns([
                        'default' => 2,
                        'sm' => 1
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                \Jeffgreco13\FilamentBreezy\BreezyCore::make()
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        shouldRegisterNavigation: false,
                        navigationGroup: 'Settings',
                        hasAvatars: true,
                        slug: 'my-profile'
                    )
                    ->myProfileComponents([
                        'personal_info' => MyProfileExtended::class,
                    ]),
                \Datlechin\FilamentMenuBuilder\FilamentMenuBuilderPlugin::make()
                    ->usingResource(MenuResource::class)
                    ->addMenuPanels([
                        \Datlechin\FilamentMenuBuilder\MenuPanel\StaticMenuPanel::make()
                            ->addMany([
                                'Home' => url('/'),
                                'Blog' => url('/blog'),
                            ])
                            ->description('Default menus')
                            ->collapsed(true)
                            ->collapsible(true)
                            ->paginate(perPage: 5, condition: true)
                            ]),
                \MarcoGermani87\FilamentCaptcha\FilamentCaptcha::make(),
            ])
            ->spa();
    }
}
