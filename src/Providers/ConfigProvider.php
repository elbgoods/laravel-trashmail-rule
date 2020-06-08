<?php

namespace Elbgoods\TrashmailRule\Providers;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;

class ConfigProvider implements ProviderContract
{
    protected array $allowed;
    protected array $denied;

    public function __construct(array $allowed, array $denied)
    {
        $this->allowed = $allowed;
        $this->denied = $denied;
    }

    public function isDisposable(string $domain): ?bool
    {
        if (in_array($domain, $this->allowed)) {
            return false;
        }

        if (in_array($domain, $this->denied)) {
            return true;
        }

        return null;
    }
}
