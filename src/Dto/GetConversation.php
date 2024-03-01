<?php

namespace App\Dto;

class GetConversation
{
    public ?string $id = null;

    public ?array $messages = null;

    public ?array $settings = null;

    public ?array $users = null;
}