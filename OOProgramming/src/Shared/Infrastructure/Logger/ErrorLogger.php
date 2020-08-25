<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Logger;

use App\Shared\Domain\Observer\IObservable;
use App\Shared\Domain\Observer\IObserver;
use App\Shared\Infrastructure\FeedParser\FeedParserBase;

class ErrorLogger implements IObserver
{
    public function notify(IObservable $objSource, $strMessage): void
    {
        if ($objSource instanceof FeedParserBase) {
            printf('ERROR -> %s.' . PHP_EOL, $strMessage);
        }
    }
}
