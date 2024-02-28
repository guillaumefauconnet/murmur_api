<?php

namespace App\Dto;

class GetUser
{
    public ?string $mail = null;

    public ?string $password = null;

    public ?string $globalNickName = null;
}