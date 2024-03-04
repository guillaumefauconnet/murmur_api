<?php

namespace App\Dto;

class GetMessage
{
    public ?string $id = null;

    public ?string $content = null;

    public ?GetUser $user = null;
}