<?php

namespace Elbgoods\TrashmailRule;

use Illuminate\Support\ServiceProvider;

class TrashmailRuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootConfig();
            $this->bootLang();
        }
    }

    public function register(): void
    {
        $this->app->singleton(TrashmailManager::class);

        $this->app->singleton(Trashmail::class);
    }

    protected function bootConfig(): void
    {
        $this->publishes([
            __DIR__.'/../config/trashmail.php' => config_path('trashmail.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/trashmail.php', 'trashmail');
    }

    protected function bootLang(): void
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/trashmailRule'),
        ], 'lang');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'trashmailRule');
    }
}
