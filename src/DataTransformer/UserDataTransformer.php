<?php

namespace App\DataTransformer;

use App\Dto\GetUser;
use App\Dto\PostUser;
use App\Entity\User;
use Exception;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserDataTransformer
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    /**
     * @throws Exception
     */
    public function toEntity(PostUser $dto): User
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new Exception((string) $errors);
        }

        $user = new User();
        $user->setMail($dto->mail);
        $user->setPassword($dto->password);
        $user->setGlobalNickName($dto->globalNickName);

        return $user;
    }

    public function toDto(User $entity): GetUser
    {
        $dto = new GetUser();
        $dto->mail = $entity->getMail();
        $dto->password = $entity->getPassword();
        $dto->globalNickName = $entity->getGlobalNickName();

        return $dto;
    }
}