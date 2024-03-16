<?php

namespace App\Repository;

use App\Entity\Conversation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Conversation>
 *
 * @method Conversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Conversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Conversation[]    findAll()
 * @method Conversation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConversationRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly EntityManagerInterface $entityManager
    )
    {
        parent::__construct($registry, Conversation::class);
    }

    public function getByUser(User $user)
    {
        $qb = $this->createQueryBuilder("c")
            ->join("c.conversationUsers", "cu")
            ->where('cu.user = :user')
            ->setParameters(new ArrayCollection([
                new Parameter('user', $user->getId()),
            ]));

        return $qb->getQuery()->getResult();
    }

    public function save(Conversation $conversation): void
    {
        $this->entityManager->persist($conversation);
        $this->entityManager->flush();
    }
}
