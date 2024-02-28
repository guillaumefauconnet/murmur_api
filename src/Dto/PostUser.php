<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PostUser
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $mail = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public ?string $password = null;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public ?string $globalNickName = null;
}