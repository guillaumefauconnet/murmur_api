<?php

namespace App\DataTransformer;

use App\Dto\GetMessage;
use App\Dto\PostMessage;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\ConversationRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserDataTransformer $userDataTransformer,
        private readonly ConversationRepository $conversationRepository,
        private readonly Security $security
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(PostMessage $dto, $conversationId): Message
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversation = $this->conversationRepository->find($conversationId);

        /** @var $me User */
        $me = $this->security->getUser();

        $message = new Message();
        $message->setContent($dto->content);
        $message->setConversation($conversation);
        $message->setUser($me);

        return $message;
    }

    public function toDto(Message $entity): GetMessage
    {
        $dto = new GetMessage();
        $dto->id = $entity->getId();
        $dto->content = $entity->getContent();
        $dto->user = $this->userDataTransformer->toDto($entity->getUser());

        return $dto;
    }
}