<?php

namespace App\Dto\Core;

class CollectionDto extends BaseDto
{
    public ?int $count = null;

    public array $data = [];
}