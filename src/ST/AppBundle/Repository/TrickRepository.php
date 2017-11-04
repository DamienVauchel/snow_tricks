<?php

namespace ST\AppBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TrickRepository extends EntityRepository
{
    public function getTricks($page, $nbPerPage)
    {
        $query = $this->createQueryBuilder('t')
//            ->leftJoin('a.image', 'i')
//            ->addSelect('i')
            ->orderBy('t.title', 'ASC')
            ->getQuery();

        $query
            ->setFirstResult(($page-1) * $nbPerPage)
            ->setMaxResults($nbPerPage);

        return new Paginator($query, true);
    }
}
