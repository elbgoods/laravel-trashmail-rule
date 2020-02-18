<?php

namespace Elbgoods\TrashmailRule\Providers;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

class DeadLetterProvider implements ProviderContract
{
    protected const BLACKLIST_URL = 'https://www.dead-letter.email/blacklist_flat.json';

    protected array $config;
    protected CacheFactory $cache;

    public function __construct(array $config, CacheFactory $cache)
    {
        $this->config = $config;
        $this->cache = $cache;
    }

    public function isDisposable(string $domain): ?bool
    {
        if (! $this->config['enabled']) {
            return null;
        }

        if (in_array($this->hashDomain($domain), $this->getBlacklist())) {
            return true;
        }

        return null;
    }

    protected function getBlacklist(): array
    {
        if (! $this->config['cache']['enabled']) {
            return $this->loadDeadLetter();
        }

        $cache = $this->getCache();

        $key = $this->config['cache']['key'];

        if ($cache->has($key)) {
            return json_decode($cache->get($key), true);
        }

        $blacklist = $this->loadDeadLetter();

        $cache->put(
            $key,
            json_encode($blacklist),
            $this->config['cache']['ttl']
        );

        return $blacklist;
    }

    protected function loadDeadLetter(): array
    {
        $response = guzzle(
            self::BLACKLIST_URL,
            $this->config['guzzle']
        )->request('GET', '');

        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }

    protected function hashDomain(string $domain): string
    {
        return hash('sha1', hash('sha1', $domain));
    }

    protected function getCache(): CacheRepository
    {
        return $this->cache->store($this->config['cache']['store']);
    }
}
