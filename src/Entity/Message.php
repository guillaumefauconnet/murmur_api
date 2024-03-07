<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[Gedmo\SoftDeleteable(fieldName:"deletedAt", timeAware:false)]
class Message
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'guid', unique: true)]
    private ?string $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    #[ManyToOne(targetEntity: Conversation::class, inversedBy: 'messages')]
    private Conversation $conversation;

    #[ManyToOne(targetEntity: User::class, inversedBy: 'messages')]
    private User $user;

    #[ORM\Column(name:"deletedAt", type:"datetime", nullable:true)]
    private DateTime $deletedAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getConversation(): Conversation
    {
        return $this->conversation;
    }

    public function setConversation(Conversation $conversation): Message
    {
        $this->conversation = $conversation;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Message
    {
        $this->user = $user;
        return $this;
    }

    public function getDeletedAt(): DateTime
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(DateTime $deletedAt): Message
    {
        $this->deletedAt = $deletedAt;
        return $this;
    }
}
