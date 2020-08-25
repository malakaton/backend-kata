<?php

declare(strict_types=1);

namespace App\Application\Product\ParseFeed;

use App\Domain\Product\IProductParser;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ProductParseFeedHandler implements MessageHandlerInterface
{
    private IProductParser $productParser;

    public function __construct(IProductParser $productParser)
    {
        $this->productParser = $productParser;
    }

    public function __invoke(ProductParseFeedCommand $command): array
    {
        return $this->productParser->parse();
    }
}