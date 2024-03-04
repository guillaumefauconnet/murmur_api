<?php

namespace App\DataTransformer;

use App\Dto\GetConversation;
use App\Dto\PostConversation;
use App\Entity\Conversation;
use App\Entity\ConversationSetting;
use App\Entity\ConversationUser;
use App\Entity\User;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly Security $security,
        private readonly MessageDataTransformer $messageDataTransformer,
        private readonly UserDataTransformer $userDataTransformer,
        private readonly ConversationSettingDataTransformer $conversationSettingDataTransformer

    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(PostConversation $dto): Conversation
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $conversation = new Conversation();


        if ($dto->setting === null) {
            $setting = new ConversationSetting();
            $setting->setPrivate(true);
        }
        else {
            $setting = $this->conversationSettingDataTransformer->toEntity($dto->setting);
        }

        $conversation->setSetting($setting);

        if ($dto->users !== null) {
            /** @var User $me */
            $me = $this->security->getUser();

            $conversationUser = new ConversationUser();
            $conversationUser->setUser($me);
            $conversationUser->setConversation($conversation);
            $conversationUser->setNickName($me->getGlobalNickName());
            $conversationUser->setOwner(true);
            $conversationUser->setAdmin(true);
            $conversationUser->setModerator(true);
        }

        return $conversation;
    }

    public function toDto(Conversation $entity): GetConversation
    {
        $dto = new GetConversation();

        $messages = [];

        foreach ($entity->getMessages() as $message) {
            $messages[] = $this->messageDataTransformer->toDto($message);
        }

        $dto->messages = $messages;

        if ($entity->getSetting() !== null) {
            $dto->setting = $this->conversationSettingDataTransformer->toDto($entity->getSetting()) ?? null;
        }

        $users = [];

        foreach ($entity->getUsers() as $user) {
            $users[] = $this->userDataTransformer->toDto($user->getUser());
        }

        $dto->users = $users;

        return $dto;
    }
}