<?php

namespace App\EventSubscriber;

use App\Entity\Product;
use App\Message\ProductUpdatedMessage;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Messenger\MessageBusInterface;

class ProductDoctrineSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MessageBusInterface $bus
    ) {}

    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postUpdate,
        ];
    }

    public function postPersist(PostPersistEventArgs $args): void
    {
        $this->dispatchIfProduct($args->getObject());
    }

    public function postUpdate(PostUpdateEventArgs $args): void
    {
        $this->dispatchIfProduct($args->getObject());
    }

    private function dispatchIfProduct(object $entity): void
    {
        if (!$entity instanceof Product) {
            return;
        }

        $this->bus->dispatch(
            new ProductUpdatedMessage($entity->getId())
        );
    }
}
