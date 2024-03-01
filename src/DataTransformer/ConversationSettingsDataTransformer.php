<?php

namespace App\DataTransformer;

use App\Dto\GetConversationSettings;
use App\Entity\ConversationSettings;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationSettingsDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(GetConversationSettings $dto): ConversationSettings
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversationSettings = new ConversationSettings();
        $conversationSettings->setPrivate($dto->private);

        return $conversationSettings;
    }

    public function toDto(ConversationSettings $entity): GetConversationSettings
    {
        $dto = new GetConversationSettings();
        $dto->private = $entity->getPrivate();
        $dto->conversation = $this->conversationDataTransformer->toDto($entity->getConversation());

        return $dto;
    }
}