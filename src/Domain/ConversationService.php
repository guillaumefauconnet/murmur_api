<?php

namespace App\Domain;

use App\DataTransformer\ConversationDataTransformer;
use App\Dto\GetConversation;
use App\Dto\PostConversation;
use App\Entity\Conversation;
use App\Entity\User;
use App\Repository\ConversationRepository;
use Exception;
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

    /**
     * @throws Exception
     */
    public function createNewConversation(PostConversation $dto): GetConversation
    {
        $conversation = $this->transformer->toEntity($dto);

        /** @var $me User */
        $me = $this->security->getUser();
        $conversation->addUser($me);

        //dd($conversation);
        $this->repository->save($conversation);

        return $this->transformer->toDto($conversation);
    }
}