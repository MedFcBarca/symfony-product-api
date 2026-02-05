<?php

namespace App\MessageHandler;

use App\Message\ProductUpdatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class ProductUpdatedMessageHandler
{
    public function __invoke(ProductUpdatedMessage $message): void
    {
        file_put_contents(
            __DIR__ . '/../../var/product.log',
            'Product updated: ' . $message->getProductId() . ' at ' . date('Y-m-d H:i:s') . PHP_EOL,
            FILE_APPEND
        );
    }
}
