<?php

declare(strict_types=1);

namespace App\Shared\Domain\Observer;

use App\Shared\Domain\FeedParser\EventType\EventType;

interface IObservable
{
    public function addObserver(IObserver $objObserver, EventType $iEventType): void;
    public function fireEvent(EventType $iEventType, string $strMessage): void;
}
