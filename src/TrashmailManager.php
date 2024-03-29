<?php

namespace Elbgoods\TrashmailRule;

use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Elbgoods\TrashmailRule\Providers\ConfigProvider;
use Elbgoods\TrashmailRule\Providers\DisposableEmailDetectorProvider;
use Elbgoods\TrashmailRule\Providers\VerifierProvider;
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
            'allowed' => $this->config->get('trashmail.allowed'),
            'denied' => $this->config->get('trashmail.denied'),
        ]);
    }

    protected function createDisposableEmailDetectorDriver(): DisposableEmailDetectorProvider
    {
        return $this->container->make(DisposableEmailDetectorProvider::class, [
            'config' => $this->config->get('trashmail.disposable_email_detector'),
        ]);
    }

    protected function createVerifierDriver(): VerifierProvider
    {
        return $this->container->make(VerifierProvider::class, [
            'config' => $this->config->get('trashmail.verifier'),
        ]);
    }
}
