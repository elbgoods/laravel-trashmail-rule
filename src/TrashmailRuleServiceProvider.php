<?php

namespace Elbgoods\TrashmailRule;

use Illuminate\Support\ServiceProvider;

class TrashmailRuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/trashmail.php' => config_path('trashmail.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/../config/trashmail.php', 'trashmail');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/trashmailRule'),
        ], 'lang');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'trashmailRule');
    }
}
