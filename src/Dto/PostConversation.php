<?php

namespace App\Dto;

use App\Entity\ConversationSetting;

class PostConversation
{
    public ?GetConversationSetting $setting = null;

    public ?array $users = null;
}