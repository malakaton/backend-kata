<?php

declare(strict_types=1);

namespace App\Product\EntryPoint\UI\Controller;

use App\Product\Domain\Product\Product;
use App\Product\Application\Product\FeedParser\ProductFeedParserCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class DefaultController
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }
    public function __invoke(): JsonResponse
    {
        $jsonResponse = [];

        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(new ProductFeedParserCommand())->last(HandledStamp::class);

        foreach ($envelope->getResult() as $product)
        {
            /**@var Product $product **/
            $jsonResponse[] = [
                'title' => $product->title()->value(),
                'id' =>  $product->id()->value(),
                'date' => $product->pubDate()->toFormatDate(),
                'url' => $product->link()->value()
            ];
        }


        return new JsonResponse(json_encode($jsonResponse));
    }
}