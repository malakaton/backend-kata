<?php

declare(strict_types=1);

namespace App\Product\Domain\Product;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Domain\ValueObject\IntValueObject;

final class ProductId extends IntValueObject
{
    public function invokeGuard(IObservable $observable, IObserver $observer): void
    {
        if (!$this->guard($observable, $observer, 'Product id must be numeric and positive value')) {
            throw new ProductException('Product id exception occurred');
        }
    }
}