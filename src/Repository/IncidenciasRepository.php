<?php

namespace App\Repository;

use App\Entity\Incidencias;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Incidencias>
 *
 * @method Incidencias|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidencias|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidencias[]    findAll()
 * @method Incidencias[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IncidenciasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Incidencias::class);
    }

//    /**
//     * @return Incidencias[] Returns an array of Incidencias objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Incidencias
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
