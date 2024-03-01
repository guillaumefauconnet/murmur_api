<?php

namespace App\Domain;

use App\DataTransformer\ConversationDataTransformer;
use App\Entity\User;
use App\Repository\ConversationRepository;
use Symfony\Bundle\SecurityBundle\Security;


class ConversationService
{
    public function __construct(
        private readonly ConversationDataTransformer $transformer,
        private readonly ConversationRepository $repository,
        private readonly Security $security
    )
    {
    }

    public function getConversations(): array
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $conversations = $this->repository->getByUser($user);

        $dtoConversations = [];

        foreach ($conversations as $conversation) {
            $dtoConversations[] = $this->transformer->toDto($conversation);
        }

        return $dtoConversations;
    }
}