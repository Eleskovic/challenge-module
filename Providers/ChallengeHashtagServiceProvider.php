<?php

namespace Modules\ChallengeHashtag\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ChallengeHashtagServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('ChallengeHashtag', 'Database/Migrations'));
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('ChallengeHashtag', 'Config/config.php') => config_path('challengehashtag.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('ChallengeHashtag', 'Config/config.php'), 'challengehashtag'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/challengehashtag');

        $sourcePath = module_path('ChallengeHashtag', 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/challengehashtag';
        }, \Config::get('view.paths')), [$sourcePath]), 'challengehashtag');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/challengehashtag');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'challengehashtag');
        } else {
            $this->loadTranslationsFrom(module_path('ChallengeHashtag', 'Resources/lang'), 'challengehashtag');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('ChallengeHashtag', 'Database/factories'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
