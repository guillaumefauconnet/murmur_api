<?php

namespace App\Entity;

use App\Repository\ConversationSettingsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ConversationSettingsRepository::class)]
class ConversationSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'guid', unique: true)]
    private ?string $id = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $private = null;

    #[ManyToOne(targetEntity: Conversation::class, inversedBy: 'settings')]
    private Conversation $conversation;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getPrivate(): ?bool
    {
        return $this->private;
    }

    public function setPrivate(?bool $private): ConversationSetting
    {
        $this->private = $private;
        return $this;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): ConversationSetting
    {
        $this->conversation = $conversation;
        return $this;
    }
}
