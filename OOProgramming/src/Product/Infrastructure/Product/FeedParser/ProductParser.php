<?php

declare(strict_types=1);

namespace App\Product\Infrastructure\Product\FeedParser;

use App\Product\Domain\Product\IProductParser;
use App\Product\Domain\Product\Product;
use App\Product\Domain\Product\ProductException;
use App\Product\Domain\Product\ProductId;
use App\Product\Domain\Product\ProductLink;
use App\Product\Domain\Product\ProductPubDate;
use App\Product\Domain\Product\ProductTitle;
use App\Shared\Domain\FeedParser\EventType\EventName;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Infrastructure\FeedParser\EmptyFeedException;
use App\Shared\Infrastructure\FeedParser\FeedParserBase;
use App\Shared\Infrastructure\FeedParser\NotFoundFeedException;

final class ProductParser extends FeedParserBase implements IProductParser
{
    protected IObserver $infoLogger;
    protected IObserver $infoError;

    public function __construct(string $strFeedUrl, IObserver $infoLogger, IObserver $infoError)
    {
        $this->infoLogger = $infoLogger;
        $this->infoError = $infoError;

        parent::__construct($strFeedUrl);
    }

    /**
     * @return array
     * @throws EmptyFeedException|NotFoundFeedException
     */
    public function parse(): array
    {
        /**
         * Log start
         */
        $this->invokeEvent(
            $this->infoLogger,
            $this->createEventType(new EventName(EventName::feed_parser_start)),
            EventName::feed_parser_start . ', from feed: ' .  $this->getFeedUrl()
        );

        return $this->loadFeed();
    }

    /**
     * @return array
     * @throws EmptyFeedException|NotFoundFeedException
     */
    private function loadFeed(): array
    {
        try {
            $fileContents = file_get_contents($this->getFeedUrl());
            $fileContents = str_replace(array("\n", "\r", "\t"), '', $fileContents);
            $fileContents = trim(str_replace('"', "'", $fileContents));
            $simpleXml = simplexml_load_string($fileContents);
        } catch (\Exception $e) {
            $this->invokeEvent(
                $this->infoError,
                $this->createEventType(new EventName(EventName::feed_not_found)),
                EventName::feed_not_found
            );

            throw new NotFoundFeedException(
                'Not found feed exception occurred',
                [
                    'feed' => $e->getMessage()
                ]
            );
        }

        if ($simpleXml === false || is_null($simpleXml)) {
            $this->invokeEvent(
                $this->infoError,
                $this->createEventType(new EventName(EventName::feed_is_empty)),
                EventName::feed_is_empty
            );

            throw new EmptyFeedException(
                'Empty feed exception occurred',
                [
                    'feed' => 'The source content of feed is empty'
                ]
            );
        }

        return $this->createProductsFromFeed($simpleXml);
    }

    /**
     * @param \SimpleXMLElement $xmlItems
     * @return array
     */
    private function createProductsFromFeed(\SimpleXMLElement $xmlItems): array
    {
        $products = [];

        foreach ($xmlItems as $item) {
            try {
                /**
                 * Product Id parser
                 */
                $urlExploded = explode('/', (string) $item->link);

                $id = new ProductId((int)$urlExploded[count($urlExploded) - 1]);
                $id->invokeGuard($this, $this->infoError);
                $this->infoLogger->notify($this, "Product id: {$id->value()} parsed");

                /**
                 * Product title parser
                 */
                $title = new ProductTitle((string) $item->title);
                $title->invokeGuard($this, $this->infoError);
                $this->infoLogger->notify($this, "Product title: {$title->value()} parsed");

                /**
                 * Product link parser
                 */
                $link = new ProductLink((string) $item->link);
                $link->invokeGuard($this, $this->infoError);
                $this->infoLogger->notify($this, "Product link: {$link->value()} parsed");

                /**
                 * Product pubDate parser
                 */
                $pubDate = new ProductPubDate((string) $item->pubDate);
                $pubDate->invokeGuard($this, $this->infoError);
                $this->infoLogger->notify($this, "Product date: {$pubDate->toFormatDate()} parsed");

                $products[] = Product::create(
                    $id,
                    $title,
                    $link,
                    $pubDate
                );
            } catch (ProductException $e) {
                printf('EXCEPTION -> %s. ERROR CODE -> %s.' . PHP_EOL, $e->getMessage(), $e->getCode());
            }
        }

        /**
         * Log end
         */
        $this->invokeEvent(
            $this->infoLogger,
            $this->createEventType(new EventName(EventName::feed_parser_end)),
            EventName::feed_parser_end . ', from feed: ' . $this->getFeedUrl()
        );

        return $products;
    }
}