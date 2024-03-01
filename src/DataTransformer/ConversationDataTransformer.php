<?php

namespace App\DataTransformer;

use App\Dto\GetConversation;
use App\Entity\Conversation;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly MessageDataTransformer $messageDataTransformer,
        private readonly UserDataTransformer $userDataTransformer,
        private readonly ConversationSettingsDataTransformer $conversationSettingsDataTransformer

    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(GetConversation $dto): Conversation
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversation = new Conversation();

        if ($dto->messages !== null) {
            $conversation->setMessages($this->messageDataTransformer->toEntity($dto->messages));
        }

        if ($dto->conversationSettings !== null) {
            $conversation->setSettings($this->conversationSettingsDataTransformer->toEntity($dto->settings));
        }

        if ($dto->users !== null) {
            $conversation->setUsers($this->userDataTransformer->toEntity($dto->users));
        }


        return $conversation;
    }

    public function toDto(Conversation $entity): GetConversation
    {
        $dto = new GetConversation();
        $dto->messages = $this->messageDataTransformer->toDto($entity->getMessages());
        $dto->settings = $this->conversationSettingsDataTransformer->toDto($entity->getSettings());
        $dto->users = $this->userDataTransformer->toDto($entity->getUsers());

        return $dto;
    }
}