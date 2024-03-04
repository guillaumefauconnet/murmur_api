<?php

namespace App\DataTransformer;

use App\Dto\GetMessage;
use App\Entity\Message;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class MessageDataTransformer
{
    public function __construct(
        private readonly ValidatorInterface $validator,
        private readonly UserDataTransformer $userDataTransformer
    )
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(GetMessage $dto): Message
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $message = new Message();
        $message->setContent($dto->content);

        if ($dto->user !== null) {
            $message->setUser($this->userDataTransformer->toEntity($dto->user));
        }

        return $message;
    }

    public function toDto(Message $entity): GetMessage
    {
        $dto = new GetMessage();
        $dto->content = $entity->getContent();
        $dto->user = $this->userDataTransformer->toDto($entity->getUser());

        return $dto;
    }
}