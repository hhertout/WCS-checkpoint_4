<?php

namespace App\Repository;

use App\Entity\Hike;
use App\Entity\SearchBar;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Hike>
 *
 * @method Hike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hike[]    findAll()
 * @method Hike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hike::class);
    }

    public function save(Hike $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Hike $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findBySearch(SearchBar $search): array
    {
        $query =  $this->createQueryBuilder('h')
        ->andWhere('h.season = :season')
        ->setParameter('season', $search->getSeason());

        if ($search->getType() !== null) {
            $query->andWhere('h.type = :type')
            ->setParameter('type', $search->getType());
        }
        if ($search->getValley() !== null) {
            $query->andWhere('l.valley = :val')
            ->leftJoin('h.location', 'l')
            ->setParameter('val', $search->getValley());
        }
        return $query->getQuery()->getResult();
    }

    //    public function findOneBySomeField($value): ?Hike
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
