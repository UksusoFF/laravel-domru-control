<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Http\Middleware\VerifyCsrfToken;
use App\Orchid\Models\Account\AccountEditScreen;
use App\Orchid\Models\Account\AccountListScreen;
use App\Orchid\Models\DashboardScreen;
use App\Orchid\Models\Role\RoleEditScreen;
use App\Orchid\Models\Role\RoleListScreen;
use App\Orchid\Models\User\UserEditScreen;
use App\Orchid\Models\User\UserListScreen;
use App\Orchid\Models\User\UserProfileScreen;
use Aranyasen\LaravelAdminer\AdminerAutologinController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Orchid\Support\Facades\Dashboard;
use Tabuna\Breadcrumbs\Trail;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerRoutes();
    }

    protected function registerRoutes(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Routes
        |--------------------------------------------------------------------------
        |
        | Here is where you can register web routes for your application. These
        | routes are loaded by the RouteServiceProvider within a group which
        | contains the need "dashboard" middleware group. Now create something great!
        |
        */

        Route::prefix(Dashboard::prefix('/'))
            ->middleware(config('platform.middleware.private'))
            ->group(function() {
                // Main
                Route::screen('/main', DashboardScreen::class)
                    ->name('platform.main');

                // Platform > Profile
                Route::screen('profile', UserProfileScreen::class)
                    ->name('platform.profile')
                    ->breadcrumbs(fn(Trail $trail) => $trail
                        ->parent('platform.index')
                        ->push(__('Profile'), route('platform.profile')));

                // Platform > System > Users
                Route::screen('users/{user}/edit', UserEditScreen::class)
                    ->name('platform.systems.users.edit')
                    ->breadcrumbs(fn(Trail $trail, $user) => $trail
                        ->parent('platform.systems.users')
                        ->push(__('User'), route('platform.systems.users.edit', $user)));

                // Platform > System > Users > Create
                Route::screen('users/create', UserEditScreen::class)
                    ->name('platform.systems.users.create')
                    ->breadcrumbs(fn(Trail $trail) => $trail
                        ->parent('platform.systems.users')
                        ->push(__('Create'), route('platform.systems.users.create')));

                // Platform > System > Users > User
                Route::screen('users', UserListScreen::class)
                    ->name('platform.systems.users')
                    ->breadcrumbs(fn(Trail $trail) => $trail
                        ->parent('platform.index')
                        ->push(__('Users'), route('platform.systems.users')));

                // Platform > System > Roles > Role
                Route::screen('roles/{role}/edit', RoleEditScreen::class)
                    ->name('platform.systems.roles.edit')
                    ->breadcrumbs(fn(Trail $trail, $role) => $trail
                        ->parent('platform.systems.roles')
                        ->push(__('Role'), route('platform.systems.roles.edit', $role)));

                // Platform > System > Roles > Create
                Route::screen('roles/create', RoleEditScreen::class)
                    ->name('platform.systems.roles.create')
                    ->breadcrumbs(fn(Trail $trail) => $trail
                        ->parent('platform.systems.roles')
                        ->push(__('Create'), route('platform.systems.roles.create')));

                // Platform > System > Roles
                Route::screen('roles', RoleListScreen::class)
                    ->name('platform.systems.roles')
                    ->breadcrumbs(fn(Trail $trail) => $trail
                        ->parent('platform.index')
                        ->push(__('Roles'), route('platform.systems.roles')));

                Route::screen('account/create', AccountEditScreen::class)->name('admin.accounts.create');
                Route::screen('account/{model}/edit', AccountEditScreen::class)->name('admin.accounts.edit');
                Route::screen('accounts', AccountListScreen::class)->name('admin.accounts');

                Route::prefix('system')->group(function(): void {
                    Route::any('db', [AdminerAutologinController::class, 'index'])->withoutMiddleware([
                        VerifyCsrfToken::class,
                    ]);
                });

            });
    }
}
