<?php

namespace Elbgoods\TrashmailRule\Rules;

use Elbgoods\TrashmailRule\Facades\Trashmail;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class TrashmailRule implements Rule
{
    protected bool $required;

    public function __construct(bool $required = true)
    {
        $this->required = $required;
    }

    public function nullable(): self
    {
        $this->required = false;

        return $this;
    }

    /**
     * @param string $attribute
     * @param mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($value === null && $this->isNullable()) {
            return true;
        }

        if (! is_string($value)) {
            return false;
        }

        if (! Str::contains($value, '@')) {
            return false;
        }

        return ! Trashmail::isDisposable($value);
    }

    public function message(): string
    {
        return Lang::get('trashmailRule::validation.trash_mail');
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function isNullable(): bool
    {
        return ! $this->required;
    }
}
