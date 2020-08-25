<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\FeedParser;

use App\Shared\Domain\FeedParser\EventType\EventName;
use App\Shared\Domain\FeedParser\EventType\EventType;
use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;

abstract class FeedParserBase implements IObservable
{
    protected const EVENT_FEED_INFO = 1;
    protected const EVENT_FEED_ERROR = 2;

    protected string $_strFeedUrl;
    protected array $_aObservers;

    public function __construct($strFeedUrl)
    {
        $this->_strFeedUrl = $strFeedUrl;
    }

    public function getFeedUrl(): string
    {
        return $this->_strFeedUrl;
    }

    public function addObserver(IObserver $objLogger, EventType $iEventType): void
    {
        $this->_aObservers[$iEventType->name()->value()][] = $objLogger;
    }

    public function fireEvent(EventType $iEventType, string $strMessage): void
    {
        if (isset($this->_aObservers[$iEventType->name()->value()])
            && is_array($this->_aObservers[$iEventType->name()->value()])) {
            foreach ($this->_aObservers[$iEventType->name()->value()] as $objObserver) {
                $objObserver->notify($this, $strMessage);
            }
        }
    }

    protected function createEventType(EventName $name): EventType
    {
        return new EventType($name);
    }

    protected function invokeEvent(IObserver $logger, EventType $eventType,string $message): void
    {
        $this->addObserver($logger, $eventType);

        $this->fireEvent($eventType, $message);
    }

    abstract public function parse(): array;
}
