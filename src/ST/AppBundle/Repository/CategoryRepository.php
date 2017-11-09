<?php

namespace ST\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class CategoryRepository extends EntityRepository
{
    public function findBySlug($slug)
    {
        $query = $this->createQueryBuilder('c')
            ->where('c.slug = :slug')
            ->setParameter('slug', $slug)
            ->getQuery();

        return $query->getOneOrNullResult();
    }

    public function findAllByName()
    {
        $query = $this->createQueryBuilder('c')
            ->orderBy('c.name')
            ->getQuery();

        return $query->getResult();
    }
}
