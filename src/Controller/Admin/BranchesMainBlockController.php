<?php

namespace App\Controller\Admin;

use Doctrine\ORM\QueryBuilder;

class BranchesMainBlockController extends AdminController
{
    const PAGE_BLOCK_TYPE = 'branches_main_block';

    protected function getEntityClass()
    {
        return \App\Entity\PageBlock::class;
    }

    protected function getForm()
    {
        return \App\Form\Admin\BranchesMainBlockType::class;
    }

    protected function setIndexFields(IndexFieldsBuilder $builder)
    {
        $builder->add('id', '#');
    }

    protected function getSlug()
    {
        return self::PAGE_BLOCK_TYPE;
    }

    protected function addQuery(QueryBuilder $queryBuilder)
    {
        return $queryBuilder->andWhere($queryBuilder->expr()->eq($this->getSlug() . '.type', ':type'))
            ->setParameter('type', self::PAGE_BLOCK_TYPE);
    }

    protected function createEntity()
    {
        $entity = new ($this->getEntityClass());
        $entity->setType(self::PAGE_BLOCK_TYPE);
        $entity->setSlug(self::PAGE_BLOCK_TYPE);
        return $entity;
    }
}
