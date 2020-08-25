<?php

declare(strict_types=1);

namespace App\Product\Application\Product\FeedParser;

use App\Product\Domain\Product\IProductParser;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ProductFeedParserHandler implements MessageHandlerInterface
{
    private IProductParser $productParser;

    public function __construct(IProductParser $productParser)
    {
        $this->productParser = $productParser;
    }

    public function __invoke(ProductFeedParserCommand $command): array
    {
        return $this->productParser->parse();
    }
}