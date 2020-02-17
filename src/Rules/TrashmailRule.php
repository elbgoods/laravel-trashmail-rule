<?php

namespace Elbgoods\TrashmailRule\Rules;

use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class TrashmailRule implements Rule
{
    protected const BLACKLIST_URL = 'https://www.dead-letter.email/blacklist_flat.json';

    protected bool $required;

    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    public function nullable(): self
    {
        $this->required = false;

        return $this;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($value === null && $this->isNullable()) {
            return true;
        }

        if (! is_string($value)) {
            return false;
        }

        if (! Str::contains($value, '@')) {
            return false;
        }

        $domain = trim(mb_strtolower(Str::after($value, '@')));

        if (in_array($domain, config('trashmail.whitelist'))) {
            return true;
        }

        return ! in_array(
            $this->hashDomain($domain),
            $this->getBlacklist()
        );
    }

    public function message(): string
    {
        return Lang::get('trashmailRule::validation.trash_mail');
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isNullable(): bool
    {
        return ! $this->required;
    }

    protected function getBlacklist(): array
    {
        $deadLetter = $this->getDeadLetter();

        $blacklist = array_map([$this, 'hashDomain'], config('trashmail.blacklist'));

        return array_merge($deadLetter, $blacklist);
    }

    protected function getDeadLetter(): array
    {
        if (! config('trashmail.dead_letter.enabled')) {
            return [];
        }

        if (! config('trashmail.dead_letter.cache.enabled')) {
            return $this->loadDeadLetter();
        }

        /** @var CacheRepository $cache */
        $cache = app('cache')->store(config('trashmail.dead_letter.cache.store'));

        $key = config('trashmail.dead_letter.cache.key');

        if ($cache->has($key)) {
            return json_decode($cache->get($key), true);
        }

        $blacklist = $this->loadDeadLetter();

        $cache->put(
            $key,
            json_encode($blacklist),
            config('trashmail.dead_letter.cache.ttl')
        );

        return $blacklist;
    }

    protected function loadDeadLetter(): array
    {
        $response = guzzle(
            self::BLACKLIST_URL,
            config('trashmail.dead_letter.guzzle')
        )->request('GET', '');

        $body = $response->getBody()->getContents();

        return json_decode($body, true);
    }

    protected function hashDomain(string $domain): string
    {
        return hash('sha1', hash('sha1', $domain));
    }
}
