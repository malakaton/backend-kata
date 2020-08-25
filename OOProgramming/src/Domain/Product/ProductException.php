<?php

declare(strict_types=1);

namespace App\Domain\Product;

use App\Shared\Domain\DomainError;

final class ProductException extends DomainError
{
    private string $errorMessage;

    public function __construct(string $errorMessage)
    {
        $this->errorMessage = $errorMessage;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'product_parser_feed_error';
    }

    protected function errorMessage(): string
    {
        return sprintf($this->errorMessage);
    }
}