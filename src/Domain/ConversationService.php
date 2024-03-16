<?php

namespace App\Domain;

use App\DataTransformer\ConversationDataTransformer;
use App\Dto\GetConversation;
use App\Dto\PatchConversation;
use App\Dto\PostConversation;
use App\Entity\ConversationUser;
use App\Entity\User;
use App\Repository\ConversationRepository;
use App\Repository\ConversationUserRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class ConversationService
{
    public function __construct(
        private readonly ConversationDataTransformer $transformer,
        private readonly ConversationRepository $conversationRepository,
        private readonly UserRepository $userRepository,
        private readonly ConversationUserRepository $conversationUserRepository,
        private readonly Security $security
    )
    {}

    public function getMyConversations(): array
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $conversations = $this->conversationRepository->getByUser($user);

        $dtoConversations = [];

        foreach ($conversations as $conversation) {
            $dtoConversations[] = $this->transformer->toDto($conversation);
        }

        return $dtoConversations;
    }

    public function getOneConversation(string $conversationId): GetConversation
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $conversation = $this->conversationRepository->find($conversationId);

        if ($conversation && $conversation->hasUser($user)) {
            return $this->transformer->toDto($conversation);
        }

        throw new NotFoundHttpException('Conversation not found');
    }

    /**
     * @throws Exception
     */
    public function createNewConversation(PostConversation $dto): GetConversation
    {
        $conversation = $this->transformer->toEntity($dto);

        /** @var $me User */
        $me = $this->security->getUser();

        $conversationUser = new ConversationUser();
        $conversationUser->setUser($me);
        $conversationUser->setConversation($conversation);
        $conversationUser->setNickName($me->getGlobalNickName());
        $conversationUser->setOwner(true);
        $conversationUser->setAdmin(true);
        $conversationUser->setModerator(true);

        $conversation->addConversationUser($conversationUser);

        $this->conversationRepository->save($conversation);

        return $this->transformer->toDto($conversation);
    }

    /**
     * @throws Exception
     */
    public function updateConversation(PatchConversation $dto, string $conversationId): GetConversation
    {
        $conversation = $this->transformer->toEntity($dto, $conversationId);

        $this->conversationRepository->save($conversation);

        return $this->transformer->toDto($conversation);
    }

    public function addUserToConversation(string $conversationId, string $userId): GetConversation
    {
        $conversation = $this->conversationRepository->find($conversationId);
        $user = $this->userRepository->find($userId);

        $conversationUser = new ConversationUser();
        $conversationUser->setUser($user);
        $conversationUser->setConversation($conversation);
        $conversationUser->setNickName($user->getGlobalNickName());
        $conversationUser->setOwner(false);
        $conversationUser->setAdmin(false);
        $conversationUser->setModerator(false);

        $conversation->addConversationUser($conversationUser);

        $this->conversationRepository->save($conversation);

        return $this->transformer->toDto($conversation);
    }

    public function removeUserToConversation(string $conversationId, string $userId): GetConversation
    {
        $conversation = $this->conversationRepository->find($conversationId);
        $user = $this->userRepository->find($userId);

        $conversationUser = $this->conversationUserRepository->findOneBy(
            ['user' => $user, 'conversation' => $conversation]
        );

        $this->conversationUserRepository->delete($conversationUser->getId());

        return $this->transformer->toDto($conversation);
    }
}