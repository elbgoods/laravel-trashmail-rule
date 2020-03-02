<?php

namespace Elbgoods\TrashmailRule\Providers;

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use Elbgoods\TrashmailRule\Contracts\ProviderContract;

class DisposableEmailDetectorProvider implements ProviderContract
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function isDisposable(string $domain): ?bool
    {
        if (! $this->config['enabled']) {
            return null;
        }

        $response = Guzzle::client('api.disposable-email-detector.com')
            ->request('GET', 'api/dea/v1/check/'.urlencode($domain));

        $body = $response->getBody()->getContents();

        return json_decode($body, true)['result']['isDisposable'] ?? null;
    }
}
