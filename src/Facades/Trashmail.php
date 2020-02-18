<?php

namespace Elbgoods\TrashmailRule\Facades;

use Closure;
use Elbgoods\TrashmailRule\Contracts\ProviderContract;
use Elbgoods\TrashmailRule\Trashmail as TrashmailService;
use Elbgoods\TrashmailRule\TrashmailManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isDisposable(string $email)
 * @method static ProviderContract provider(string $provider)
 * @method static string getDomain(string $email)
 * @method static TrashmailManager extend(string $provider, Closure $creator)
 */
class Trashmail extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TrashmailService::class;
    }
}
