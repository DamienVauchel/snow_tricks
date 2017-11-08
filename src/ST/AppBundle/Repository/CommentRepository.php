<?php

namespace ST\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CommentRepository extends EntityRepository
{
    public function findByTrick($trick_id, $page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.author', 'a')
            ->addSelect('a')
            ->where('c.trick = :trick')
            ->setParameter('trick', $trick_id)
            ->orderBy('c.creationDate', 'DESC')
            ->getQuery();

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }
}
