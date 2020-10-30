<?php

namespace Larke\Auth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

use Larke\Auth\Models\Rule;
use Larke\Auth\Observers\RuleObserver;
use Larke\Auth\Contracts\AuthUser as AuthUserContract;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([__DIR__ . '/../config/larkeauth-rbac-model.conf' => config_path('larkeauth-rbac-model.conf')], 'larke-auth-config');
            $this->publishes([__DIR__ . '/../config/larkeauth.php' => config_path('larkeauth.php')], 'larke-auth-config');

            $this->commands([
                Commands\Install::class,
                Commands\GroupAdd::class,
                Commands\PolicyAdd::class,
                Commands\RoleAssign::class,
            ]);
        }

        $this->mergeConfigFrom(__DIR__ . '/../config/larkeauth.php', 'larkeauth');

        $this->bootObserver();
    }
    
    /**
     * Boot Observer.
     *
     * @return void
     */
    protected function bootObserver()
    {
        Rule::observe(new RuleObserver());
    }

    /**
     * Register bindings in the container.
     */
    public function register()
    {
        $this->app->bind('larke.auth.user', AuthUserContract::class);
        
        $this->app->singleton('enforcer', function ($app) {
            return new EnforcerManager($app);
        });
    }
}
