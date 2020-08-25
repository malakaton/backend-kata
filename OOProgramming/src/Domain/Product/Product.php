<?php

declare(strict_types=1);

namespace App\Domain\Product;

final class Product
{
    private ProductId $id;
    private ProductTitle $title;
    private ProductLink $link;
    private ProductPubDate $pubDate;

    public function __construct(
        ProductId $id,
        ProductTitle $title,
        ProductLink $link,
        ProductPubDate $pubDate
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->link = $link;
        $this->pubDate = $pubDate;
    }

    public static function create(
        ProductId $id,
        ProductTitle $title,
        ProductLink $link,
        ProductPubDate $pubDate
    ): Product
    {
        return new self($id, $title, $link, $pubDate);
    }

    public function id(): ProductId
    {
        return $this->id;
    }

    public function title(): ProductTitle
    {
        return $this->title;
    }

    public function link(): ProductLink
    {
        return $this->link;
    }

    public function pubDate(): ProductPubDate
    {
        return $this->pubDate;
    }
}