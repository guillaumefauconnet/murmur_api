<?php

namespace App\Dto;

class GetConversationSetting
{
    public ?string $id = null;

    public ?bool $private = null;

    public ?GetConversation $conversation = null;
}