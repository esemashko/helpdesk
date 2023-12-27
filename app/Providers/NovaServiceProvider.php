<?php

namespace App\Providers;

use App\Nova\Company;
use App\Nova\Dashboards\Main;
use App\Nova\Priority;
use App\Nova\Status;
use App\Nova\Ticket;
use App\Nova\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Sereny\NovaPermissions\Nova\Permission;
use Sereny\NovaPermissions\Nova\Role;
use Sereny\NovaPermissions\NovaPermissions;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::withBreadcrumbs();

        Nova::initialPath('/resources/tickets');
        $this->getFooterContent();
        $this->getCustomMenu();
    }

    /**
     * @return void
     */
    private function getFooterContent(): void
    {
        Nova::footer(static function () {
            return Blade::render('nova/footer');
        });
    }

    private function getCustomMenu()
    {
        Nova::mainMenu(static function (Request $request) {
            return [
                MenuSection::dashboard(Main::class)->icon('chart-bar'),

                MenuSection::make('HelpDesk', [
                    MenuItem::resource(Ticket::class),
                    MenuItem::resource(Company::class),
                    MenuItem::resource(User::class),
                ])->icon('collection')->collapsable(),

                MenuSection::make('Settings', [
                    MenuItem::resource(Priority::class),
                    MenuItem::resource(Status::class),
                ])->icon('adjustments')->collapsable(),

                MenuSection::make('Permissions', [
                    MenuItem::resource(Role::class),
                    MenuItem::resource(Permission::class),
                ])->icon('shield-check')->collapsable(),

            ];
        });
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            new NovaPermissions(),
        ];
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
            ->withAuthenticationRoutes()
            ->withPasswordResetRoutes()
            ->register();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new Main,
        ];
    }
}
