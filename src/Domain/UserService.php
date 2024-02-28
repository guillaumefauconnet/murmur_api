<?php

namespace App\Domain;

use App\DataTransformer\UserDataTransformer;
use App\Dto\GetUser;
use App\Dto\PostUser;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(
        private readonly UserDataTransformer $transformer,
        private readonly UserRepository $repository
    )
    {
    }

    public function registerUser(PostUser $dto): GetUser
    {
        $user = $this->transformer->toEntity($dto);

        $this->repository->save($user);

        return $this->transformer->toDto($user);
    }
}