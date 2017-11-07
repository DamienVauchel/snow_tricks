<?php

namespace ST\AppBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class TrickRepository extends EntityRepository
{
    public function getTricks()
    {
        $query = $this->createQueryBuilder('t')
            ->leftJoin('t.image', 'i')
            ->addSelect('i')
            ->orderBy('t.title')
            ->getQuery();

        return $query->getResult();
    }

    public function getGroupTricks($id)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.category = :id')
            ->setParameter('id', $id)
            ->getQuery();

        return $query->getArrayResult();
    }

    public function findBySlug($slug)
    {
        $query = $this->createQueryBuilder('t')
            ->where('t.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();

        return $query->getResult();
    }
}
