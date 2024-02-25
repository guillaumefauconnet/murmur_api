<?php

namespace App\Repository;

use App\Entity\ConversationSettings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationSettings>
 *
 * @method ConversationSettings|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationSettings|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationSettings[]    findAll()
 * @method ConversationSettings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationSettings::class);
    }

    //    /**
    //     * @return ConversationSettings[] Returns an array of ConversationSettings objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ConversationSettings
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
