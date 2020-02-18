<?php

namespace Elbgoods\TrashmailRule\Providers;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class DisposableEmailDetectorProvider implements ProviderContract
{
    protected const BASE_URL = 'https://api.disposable-email-detector.com/api/dea/v1/check/';

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

        $response = guzzle(
            self::BASE_URL,
            $this->config['guzzle']
        )->request('GET', $domain);

        $body = $response->getBody()->getContents();

        return json_decode($body, true)['result']['isDisposable'] ?? null;
    }
}
