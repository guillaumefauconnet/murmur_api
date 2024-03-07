<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class PostMessage
{
    #[Assert\NotNull]
    #[Assert\NotBlank]
    public string $content;
}