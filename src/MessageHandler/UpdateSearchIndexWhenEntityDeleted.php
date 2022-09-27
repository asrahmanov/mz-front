<?php

namespace App\MessageHandler;

use App\Message\EntityDeleted;
use App\Service\Search\SearchIndex;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class UpdateSearchIndexWhenEntityDeleted implements MessageHandlerInterface
{
    private SearchIndex $searchIndex;
    private EntityManagerInterface $em;

    public function __construct(SearchIndex $searchIndex, EntityManagerInterface $em)
    {
        $this->searchIndex = $searchIndex;
        $this->em = $em;
    }

    public function __invoke(EntityDeleted $message)
    {
        $entity = $this->em->getRepository($message->getEntityClass())->find($message->getEntityId());
        $this->searchIndex->delete($entity);
    }
}
