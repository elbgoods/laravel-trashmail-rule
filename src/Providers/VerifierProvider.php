<?php

namespace Elbgoods\TrashmailRule\Providers;

use Astrotomic\LaravelGuzzle\Facades\Guzzle;
use Elbgoods\TrashmailRule\Contracts\ProviderContract;

class VerifierProvider implements ProviderContract
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

        if (empty($this->config['api_key'])) {
            return null;
        }

        $response = Guzzle::client('verifier.meetchopra.com')
            ->request('GET', 'verify/'.urlencode($domain), [
                'query' => [
                    'token' => $this->config['api_key'],
                ],
            ]);

        $body = $response->getBody()->getContents();

        return (! json_decode($body, true)['status']) ?? null;
    }
}
