<?php

namespace App\Dto;

use App\Entity\ConversationSetting;

class GetConversation
{
    public function __construct()
    {
        $this->id = null;
        $this->messages = null;
        $this->setting = null;
        $this->users = null;
    }

    public ?string $id = null;

    public ?array $messages = null;

    public ?GetConversationSetting $setting = null;

    public ?array $users = null;
}