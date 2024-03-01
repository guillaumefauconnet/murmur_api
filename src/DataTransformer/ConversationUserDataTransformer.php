<?php

namespace App\DataTransformer;

use App\Dto\GetConversationUser;
use App\Entity\ConversationUser;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationUserDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly ConversationDataTransformer $conversationDataTransformer
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(GetConversationUser $dto): ConversationUser
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversationUser = new ConversationUser();
        $conversationUser->setNickName($dto->nickName);
        $conversationUser->setOwner($dto->owner);
        $conversationUser->setAdmin($dto->admin);
        $conversationUser->setModerator($dto->moderator);

        if ($dto->conversation !== null) {
            $conversationUser->setConversation($this->conversationDataTransformer->toEntity($dto->conversation));
        }

        return $conversationUser;
    }

    public function toDto(ConversationUser $entity): GetConversationUser
    {
        $dto = new GetConversationUser();
        $dto->nickName = $entity->getNickName();
        $dto->owner = $entity->getOwner();
        $dto->admin = $entity->getAdmin();
        $dto->moderator = $entity->getModerator();
        $dto->conversation = $this->conversationDataTransformer->toDto($entity->getConversation());

        return $dto;
    }
}