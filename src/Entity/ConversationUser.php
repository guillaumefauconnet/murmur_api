<?php

namespace App\Entity;

use App\Repository\ConversationUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;

#[ORM\Entity(repositoryClass: ConversationUserRepository::class)]
class ConversationUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'guid', unique: true)]
    private ?string $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nickName = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $owner = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $admin = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $moderator = null;

    #[ManyToOne(targetEntity: Conversation::class, inversedBy: 'users')]
    private Conversation $conversation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNickName(): ?string
    {
        return $this->nickName;
    }

    public function setNickName(?string $nickName): ConversationUser
    {
        $this->nickName = $nickName;
        return $this;
    }

    public function getOwner(): ?bool
    {
        return $this->owner;
    }

    public function setOwner(?bool $owner): ConversationUser
    {
        $this->owner = $owner;
        return $this;
    }

    public function getAdmin(): ?bool
    {
        return $this->admin;
    }

    public function setAdmin(?bool $admin): ConversationUser
    {
        $this->admin = $admin;
        return $this;
    }

    public function getModerator(): ?bool
    {
        return $this->moderator;
    }

    public function setModerator(?bool $moderator): ConversationUser
    {
        $this->moderator = $moderator;
        return $this;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): ConversationUser
    {
        $this->conversation = $conversation;
        return $this;
    }
}
