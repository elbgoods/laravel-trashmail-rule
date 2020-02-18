<?php

namespace Elbgoods\TrashmailRule\Contracts;

interface ProviderContract
{
    public function isDisposable(string $domain): ?bool;
}
