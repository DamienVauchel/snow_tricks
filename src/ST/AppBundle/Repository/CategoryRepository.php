<?php

namespace ST\AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

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
}
