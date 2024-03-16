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
}
