<?php

namespace App\Message;

final class ProductUpdatedMessage
{
    public function __construct(
        private int $productId
    ) {}

    public function getProductId(): int
    {
        return $this->productId;
    }
}
