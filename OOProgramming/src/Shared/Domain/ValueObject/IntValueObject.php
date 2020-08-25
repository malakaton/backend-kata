<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;

abstract class IntValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equalsTo(IntValueObject $other): bool
    {
        return $this->value() === $other->value();
    }

    protected function guard(IObservable $observable, IObserver $observer, string $errorMessage): bool
    {
        if (!is_numeric($this->value()) || $this->value() <= 0) {
            $observer->notify($observable, $errorMessage);

            return false;
        }

        return true;
    }
}