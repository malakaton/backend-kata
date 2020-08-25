<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Domain\ValueObject\StringValueObject;

final class ProductLink extends StringValueObject
{
    public function invokeGuard(IObservable $observable, IObserver $observer): void
    {
        if (!$this->guard($observable, $observer, 'Product link must be not empty')) {
            throw new ProductException('Product link exception occurred');
        }
    }
}