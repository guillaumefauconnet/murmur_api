<?php

namespace App\Repository;

use App\Entity\ConversationUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ConversationUser>
 *
 * @method ConversationUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConversationUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConversationUser[]    findAll()
 * @method ConversationUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationUserRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, ConversationUser::class);
    }

    public function delete(string $conversationUserId): void
    {
        $message = $this->find($conversationUserId);
        if ($message === null) {
            return;
        }
        $this->entityManager->remove($message);
        $this->entityManager->flush();
    }
}
