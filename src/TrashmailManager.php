<?php

namespace Elbgoods\TrashmailRule;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Elbgoods\TrashmailRule\Providers\ConfigProvider;
use Elbgoods\TrashmailRule\Providers\DeadLetterProvider;
use Illuminate\Support\Manager;

class TrashmailManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return 'config';
    }

    public function driver($driver = null): ProviderContract
    {
        return parent::driver($driver);
    }

    protected function createConfigDriver(): ConfigProvider
    {
        return $this->container->make(ConfigProvider::class, [
            'whitelist' => $this->config->get('trashmail.whitelist'),
            'blacklist' => $this->config->get('trashmail.blacklist'),
        ]);
    }

    protected function createDeadLetterDriver(): DeadLetterProvider
    {
        return $this->container->make(DeadLetterProvider::class, [
            'config' => $this->config->get('trashmail.dead_letter'),
        ]);
    }
}
