<?php

namespace App\DataTransformer;

use App\Dto\GetConversationSetting;
use App\Entity\ConversationSetting;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationSettingDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(GetConversationSetting $dto): ConversationSetting
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversationSettings = new ConversationSetting();
        $conversationSettings->setPrivate($dto->private);

        return $conversationSettings;
    }

    public function toDto(ConversationSetting $entity): GetConversationSetting
    {
        $dto = new GetConversationSetting();
        $dto->private = $entity->getPrivate();
        //$dto->conversation = $this->conversationDataTransformer->toDto($entity->getConversation());

        return $dto;
    }
}