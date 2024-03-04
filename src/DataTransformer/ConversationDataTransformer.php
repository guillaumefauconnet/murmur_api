<?php

namespace App\DataTransformer;

use App\Dto\GetConversation;
use App\Dto\PostConversation;
use App\Entity\Conversation;
use App\Entity\ConversationSetting;
use App\Entity\ConversationUser;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly MessageDataTransformer $messageDataTransformer,
        private readonly UserDataTransformer $userDataTransformer,
        private readonly ConversationSettingDataTransformer $conversationSettingDataTransformer,
        private readonly UserRepository $userRepository
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

        if ($dto->userIds !== null) {
            foreach ($dto->userIds as $userId) {
                $user = $this->userRepository->find($userId);

                if ($user !== null) {
                    $conversationUser = new ConversationUser();
                    $conversationUser->setUser($user);
                    $conversationUser->setConversation($conversation);
                    $conversationUser->setNickName($user->getGlobalNickName());
                    $conversationUser->setOwner(false);
                    $conversationUser->setAdmin(false);
                    $conversationUser->setModerator(false);
                }
            }
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

        foreach ($entity->getConversationUsers() as $user) {
            $users[] = $this->userDataTransformer->toDto($user->getUser());
        }

        $dto->users = $users;

        return $dto;
    }
}