<?php

namespace Elbgoods\TrashmailRule;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Elbgoods\TrashmailRule\Providers\ConfigProvider;
use Elbgoods\TrashmailRule\Providers\DeadLetterProvider;
use Elbgoods\TrashmailRule\Providers\DisposableEmailDetectorProvider;
use Illuminate\Support\Manager;
use RuntimeException;

class TrashmailManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return 'config';
    }

    /**
     * @param string|null $driver
     *
     * @return ProviderContract
     */
    public function driver($driver = null): ProviderContract
    {
        $driver = parent::driver($driver);

        if (! is_a($driver, ProviderContract::class)) {
            throw new RuntimeException(sprintf(
                'All drivers should implement [%s].',
                ProviderContract::class
            ));
        }

        return $driver;
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

    protected function createDisposableEmailDetectorDriver(): DisposableEmailDetectorProvider
    {
        return $this->container->make(DisposableEmailDetectorProvider::class, [
            'config' => $this->config->get('trashmail.disposable_email_detector'),
        ]);
    }
}
