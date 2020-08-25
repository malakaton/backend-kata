<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;

abstract class DateValueObject
{
    protected const _toFormatDate = 'Y-m-d H:i:s';

    protected string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function date(): string
    {
        return $this->date;
    }

    public function toFormatDate(): string
    {
        $dateTime = new \DateTime($this->date);

        return $dateTime->format(self::_toFormatDate);
    }

    public function guard(IObservable $observable, IObserver $observer, string $errorMessage): bool
    {
        if (empty($this->date()) || empty($this->toFormatDate())) {
            $observer->notify($observable, $errorMessage);

            return false;
        }

        return true;
    }
}