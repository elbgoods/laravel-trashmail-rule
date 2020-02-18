<?php

namespace Elbgoods\TrashmailRule;

use Exception;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\Str;
use Psr\Log\LoggerInterface;

class Trashmail
{
    protected ConfigRepository $config;
    protected TrashmailManager $manager;
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $log;

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

    protected function getDomain(string $email): string
    {
        return trim(mb_strtolower(Str::after($email, '@')));
    }
}
