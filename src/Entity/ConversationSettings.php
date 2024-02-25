<?php

namespace App\Entity;

use App\Repository\ConversationSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: ConversationSettingsRepository::class)]
class ConversationSettings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'guid', unique: true)]
    private ?string $id = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $private = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(?bool $private): ConversationSettings
    {
        $this->private = $private;
        return $this;
    }
}
