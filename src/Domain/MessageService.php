<?php

namespace App\Domain;

use App\DataTransformer\MessageDataTransformer;
use App\Dto\GetMessage;
use App\Dto\PostMessage;
use App\Entity\User;
use App\Repository\ConversationRepository;
use App\Repository\MessageRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class MessageService
{
    public function __construct(
        private readonly MessageDataTransformer $transformer,
        private readonly MessageRepository $messageRepository,
        private readonly ConversationRepository $conversationRepository,
        private readonly Security $security
    )
    {
    }

    public function getMessages($conversationId): array
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $conversations = $this->conversationRepository->getByUser($user);

        foreach ($conversations as $conversation) {
            if ($conversation->getId() === $conversationId) {

                $dtoMessages = [];
                foreach ($conversation->getMessages() as $message) {
                    $dtoMessages[] = $this->transformer->toDto($message);
                }

                return $dtoMessages;
            }
        }

        throw new NotFoundHttpException('Conversation not found');
    }

    /**
     * @throws Exception
     */
    public function createNewMessage(PostMessage $dto, string $conversationId): GetMessage
    {
        $message = $this->transformer->toEntity($dto, $conversationId);

        $this->messageRepository->save($message);

        return $this->transformer->toDto($message);
    }
}