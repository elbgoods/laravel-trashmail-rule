# Changelog

All notable changes to this package will be documented in this file.

## 0.7.0

replace insensitive language
* config key `trashmail.whitelist` to `trashmail.allowed`
* config key `trashmail.blacklist` to `trashmail.denied`
* update default validation rule translation string

## v0.6.0

* add Laravel 7 support

## v0.5.0

* upgrade `astrotomic/laravel-guzzle` to v2.0.0

## v0.4.0

* add https://verifier.meetchopra.com provider `\Elbgoods\TrashmailRule\Providers\VerifierProvider`

## v0.3.0

* add https://disposable-email-detector.com provider `\Elbgoods\TrashmailRule\Providers\DisposableEmailDetectorProvider`

## v0.2.0

* switch to manager driver pattern
  * `\Elbgoods\TrashmailRule\TrashmailManager`
  * `\Elbgoods\TrashmailRule\Providers`
* add service class `\Elbgoods\TrashmailRule\Trashmail`
* add facade `\Elbgoods\TrashmailRule\Facades\Trashmail`
* try-catch all errors in providers and skip this provider

## v0.1.0

* initial release
