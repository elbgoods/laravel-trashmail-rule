<?php

namespace Elbgoods\TrashmailRule;

use Closure;
use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Exception;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

class Trashmail
{
    protected ConfigRepository $config;
    protected TrashmailManager $manager;
    protected LoggerInterface $log;

    public function __construct(
        ConfigRepository $config,
        TrashmailManager $manager,
        LoggerInterface $log
    ) {
        $this->config = $config;
        $this->manager = $manager;
        $this->log = $log;
    }

    public function isDisposable(string $email): bool
    {
        $domain = $this->getDomain($email);

        $providers = $this->config->get('trashmail.providers');

        foreach ($providers as $provider) {
            try {
                $isDisposable = $this->manager->driver($provider)->isDisposable($domain);
            } catch (Exception $exception) {
                $this->log->error($exception);

                continue;
            }

            if ($isDisposable === null) {
                continue;
            }

            return $isDisposable;
        }

        return false;
    }

    public function provider(string $provider): ProviderContract
    {
        return $this->manager->driver($provider);
    }

    public function extend(string $provider, Closure $creator): TrashmailManager
    {
        return $this->manager->extend($provider, $creator);
    }

    public function getDomain(string $email): string
    {
        return trim(mb_strtolower(Str::after($email, '@')));
    }
}
