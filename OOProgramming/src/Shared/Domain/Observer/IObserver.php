<?php

declare(strict_types=1);

namespace App\Shared\Domain\Observer;

interface IObserver
{
    public function notify(IObservable $objSource, string $strMessage): void;
}
