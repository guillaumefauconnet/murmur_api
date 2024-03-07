<?php

namespace App\Dto;

class GetConversationUser
{
    public function __construct()
    {
        $this->nickName = null;
    }

    public string $id;

    public ?string $nickName = null;

    public bool $owner = false;

    public bool $admin = false;

    public bool $moderator = false;

    public string $conversationId;

    public string $userId;
}