<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;

abstract class StringValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function guard(IObservable $observable, IObserver $observer, string $errorMessage): bool
    {
        if (empty($this->value())) {
            $observer->notify($observable, $errorMessage);

            return false;
        }

        return true;
    }
}