<?php

declare(strict_types=1);

namespace App\Product\Domain\Product;

interface IProductParser
{
    public function parse(): array;
}