<?php

namespace App\Repository;

use App\Entity\Actu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Actu>
 */
class ActuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actu::class);
    }
    public function findOneByFamily($value): ?Actu
    {
        return $this->findOneBy(
            ['family' => $value,
                'isPublished' => true,],
            ['createdAt' => 'DESC'],


        );
    }
        public function findByLink(): array
        {
        return $this->findBy(

            ['isVideo' => true,
                'isPublished' => true],

            ['createdAt' => 'DESC'],


        );
    }
//    /**
//     * @return Actu[] Returns an array of Actu objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Actu
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
