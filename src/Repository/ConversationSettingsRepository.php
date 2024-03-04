<?php

namespace App\Repository;

use App\Entity\ConversationSetting;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationSetting>
 *
 * @method ConversationSetting|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationSetting|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationSetting[]    findAll()
 * @method ConversationSetting[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationSettingsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConversationSetting::class);
    }

    //    /**
    //     * @return ConversationSetting[] Returns an array of ConversationSetting objects
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

    //    public function findOneBySomeField($value): ?ConversationSetting
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
