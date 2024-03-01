<?php

namespace App\Dto;

class GetConversationUser
{
    public ?string $id = null;

    public ?string $nickName = null;

    public ?bool $owner = null;

    public ?bool $admin = null;

    public ?bool $moderator = null;

    public ?GetConversation $conversation = null;
}