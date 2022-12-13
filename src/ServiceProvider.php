<?php

namespace Larke\Auth;

use Illuminate\Support\Arr;
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
            $this->publishes([
                __DIR__ . '/../config/larkeauth-rbac-model.conf' => config_path('larkeauth-rbac-model.conf.larkeauth'),
                __DIR__ . '/../config/larkeauth.php' => config_path('larkeauth.php.larkeauth')
            ], 'larke-auth-config');

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
        $enforcer = $this->app["enforcer"];
        
        $guard = $enforcer->getDefaultGuard();
        $config = $this->app['config']["larkeauth.guards.{$guard}"];
        
        $ruleObserver = Arr::get($config, 'database.model_observer');
        if (empty($ruleObserver) || !class_exists($ruleObserver)) {
            $ruleObserver = RuleObserver::class;
        }
        
        Rule::observe(new $ruleObserver());
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
