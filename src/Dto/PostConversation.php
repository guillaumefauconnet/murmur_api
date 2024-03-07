<?php

namespace App\Dto;

class PostConversation
{
    public bool $private = true;

    public ?array $userIds = null;
}