<?php

namespace Elbgoods\TrashmailRule;

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\ServiceProvider;

class TrashmailRuleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->bootConfig();
            $this->bootLang();
        }

        Guzzle::register('api.disposable-email-detector.com', [
            'base_uri' => 'https://api.disposable-email-detector.com',
            RequestOptions::TIMEOUT => 5,
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::HTTP_ERRORS => true,
        ]);

        Guzzle::register('verifier.meetchopra.com', [
            'base_uri' => 'https://verifier.meetchopra.com',
            RequestOptions::TIMEOUT => 5,
            RequestOptions::ALLOW_REDIRECTS => true,
            RequestOptions::HTTP_ERRORS => true,
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'trashmailRule');
    }

    public function register(): void
    {
        $this->app->singleton(TrashmailManager::class);

        $this->app->singleton(Trashmail::class);

        $this->mergeConfigFrom(__DIR__.'/../config/trashmail.php', 'trashmail');
    }

    protected function bootConfig(): void
    {
        $this->publishes([
            __DIR__.'/../config/trashmail.php' => config_path('trashmail.php'),
        ], 'config');
    }

    protected function bootLang(): void
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/trashmailRule'),
        ], 'lang');

    }
}
