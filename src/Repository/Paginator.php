<?php


namespace App\Repository;


class Paginator extends \Doctrine\ORM\Tools\Pagination\Paginator
{
    protected $limit;
    protected $pageNum;
    public function __construct($query, $pageNum, $limit, $fetchJoinCollection = true)
    {
        $this->limit = $limit;
        $this->pageNum = $pageNum;
        $first = ($pageNum - 1) * $limit;
        $query->setFirstResult($first)
            ->setMaxResults($limit);
        parent::__construct($query, $fetchJoinCollection);
    }

    public function getPagesCount()
    {
        return (int)ceil($this->count() / $this->limit);
    }

    public function getCurrentPageNum()
    {
        return $this->pageNum;
    }
}
