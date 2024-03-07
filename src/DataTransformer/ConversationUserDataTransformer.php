<?php

namespace App\DataTransformer;

use App\Dto\GetConversationUser;
use App\Entity\ConversationUser;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationUserDataTransformer
{
    public function toDto(ConversationUser $entity): GetConversationUser
    {
        $dto = new GetConversationUser();
        $dto->nickName = $entity->getNickName();
        $dto->owner = $entity->getOwner();
        $dto->admin = $entity->getAdmin();
        $dto->moderator = $entity->getModerator();
        $dto->conversationId = $entity->getConversation()->getId();
        $dto->userId = $entity->getUser()->getId();

        return $dto;
    }
}