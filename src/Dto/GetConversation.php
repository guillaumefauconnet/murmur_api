<?php

namespace App\Dto;

class GetConversation
{
    public string $id;

    public array $messages = [];

    public bool $private;

    public array $users = [];
}