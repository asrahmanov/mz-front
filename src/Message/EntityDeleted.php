<?php

namespace App\Message;

final class EntityDeleted
{
    private string $entityClass;
    private int $entityId;

    public function __construct($entityClass, $entityId)
    {
        $this->entityClass = $entityClass;
        $this->entityId = $entityId;
    }

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    public function getEntityId(): int
    {
        return $this->entityId;
    }
}
