<?php

namespace Elbgoods\TrashmailRule\Providers;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;

class ConfigProvider implements ProviderContract
{
    protected array $whitelist;
    protected array $blacklist;

    public function __construct(array $whitelist, array $blacklist)
    {
        $this->whitelist = $whitelist;
        $this->blacklist = $blacklist;
    }

    public function isDisposable(string $domain): ?bool
    {
        if (in_array($domain, $this->whitelist)) {
            return false;
        }

        if (in_array($domain, $this->blacklist)) {
            return true;
        }

        return null;
    }
}