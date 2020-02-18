<?php

namespace Elbgoods\TrashmailRule\Providers;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;

class VerifierProvider implements ProviderContract
{
    protected const BASE_URL = 'https://verifier.meetchopra.com/verify/';

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

        $response = guzzle(
            self::BASE_URL,
            $this->config['guzzle']
        )->request('GET', $domain, [
            'query' => [
                'token' => $this->config['api_key'],
            ],
        ]);

        $body = $response->getBody()->getContents();

        return (! json_decode($body, true)['status']) ?? null;
    }
}
