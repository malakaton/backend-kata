<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Domain\ValueObject\DateValueObject;

final class ProductPubDate extends DateValueObject
{
    public function invokeGuard(IObservable $observable, IObserver $observer): void
    {
        if (!$this->guard(
            $observable,
            $observer,
            'Product pub date must be not empty and have correct date format'
        )) {
            throw new ProductException('Product pub date exception occurred');
        }
    }
}