<?php

namespace App\Dto;

class GetConversationSettings
{
    public ?string $id = null;

    public ?bool $private = null;

    public ?GetConversation $conversation = null;
}