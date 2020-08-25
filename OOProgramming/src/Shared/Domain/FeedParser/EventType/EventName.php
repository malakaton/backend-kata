<?php

declare(strict_types=1);

namespace App\Shared\Domain\FeedParser\EventType;

use App\Shared\Domain\ValueObject\StringValueObject;

final class EventName extends StringValueObject
{
    public const feed_parser_start = 'Feed parser start';
    public const feed_parser_end = 'Feed parser end';
    public const feed_not_found = 'Feed not found';
    public const feed_is_empty = 'Feed is empty';
}