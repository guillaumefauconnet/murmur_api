<?php

namespace App\DataTransformer;

use App\Dto\GetConversation;
use App\Dto\PatchConversation;
use App\Dto\PostConversation;
use App\Entity\Conversation;
use App\Entity\ConversationSetting;
use App\Entity\ConversationUser;
use App\Repository\ConversationRepository;
use App\Repository\ConversationUserRepository;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConversationDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly MessageDataTransformer $messageDataTransformer,
        private readonly ConversationUserDataTransformer $conversationUserDataTransformer,
        private readonly UserRepository $userRepository,
        private readonly ConversationRepository $conversationRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(PostConversation|PatchConversation $dto, ?string $conversationId = null): Conversation
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        if ($conversationId !== null) {
            $conversation = $this->conversationRepository->find($conversationId);
        } else {
            $conversation = new Conversation();
        }

        $setting = new ConversationSetting();
        $setting->setPrivate($dto->private);
        $conversation->setSetting($setting);

        if ($dto instanceof PostConversation && $dto->userIds !== null) {
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
        $dto->id = $entity->getId();

        $messages = [];

        foreach ($entity->getMessages() as $message) {
            $messages[] = $this->messageDataTransformer->toDto($message);
        }

        $dto->messages = $messages;
        $dto->private = $entity->getSetting()->getPrivate();

        $users = [];

        foreach ($entity->getConversationUsers() as $conversationUser) {
            $users[] = $this->conversationUserDataTransformer->toDto($conversationUser);
        }

        $dto->users = $users;

        return $dto;
    }
}