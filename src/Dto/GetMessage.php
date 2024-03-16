<?php

namespace App\Dto;

class GetMessage
{
    public string $id;

    public string $content;

    public GetUser $user;

    public string $createdAt;
}