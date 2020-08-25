<?php

namespace App\Shared\Infrastructure\Logger;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Infrastructure\FeedParser\FeedParserBase;

class InfoLogger implements IObserver
{
    public function notify(IObservable $objSource, $strMessage): void
    {
        if ($objSource instanceof FeedParserBase) {
            printf('INFO -> %s.' . PHP_EOL, $strMessage);
        }
    }
}
