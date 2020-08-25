<?php

declare(strict_types=1);

namespace App\Shared\Domain\FeedParser\EventType;

final class EventType
{
    private EventName $name;

    public function __construct(
        EventName $name
    )
    {
        $this->name = $name;
    }

    public static function create(
        EventName $name
    ): EventType
    {
        return new self($name);
    }

    public function name(): EventName
    {
        return $this->name;
    }
}