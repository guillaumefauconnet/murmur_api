<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PostUser
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $mail;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $password;

    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $globalNickName;
}