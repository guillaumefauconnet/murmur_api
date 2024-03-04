<?php

namespace App\Entity;

use App\Repository\ConversationUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ConversationUserRepository::class)]
#[ORM\Table(name: '`conversation_user`')]
class ConversationUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
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

    #[ManyToOne(targetEntity: User::class, inversedBy: 'conversationUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ManyToOne(targetEntity: Conversation::class, inversedBy: 'conversationUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private Conversation $conversation;

    public function getId(): ?string
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

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): ConversationUser
    {
        $this->user = $user;
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
