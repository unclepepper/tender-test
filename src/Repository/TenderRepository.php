<?php

namespace App\Repository;

use App\Entity\Tender;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tender>
 */
class TenderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tender::class);
    }

    public function save(Tender $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if($flush)
        {
            $this->getEntityManager()->flush();
        }
    }

}
