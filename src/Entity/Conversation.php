<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    #[ORM\Column(type: 'guid', unique: true)]
    private ?string $id = null;

    #[OneToMany(targetEntity: Message::class, mappedBy: 'conversation')]
    private Collection $messages;

    #[OneToOne(targetEntity: ConversationSettings::class)]
    #[JoinColumn(name: 'settings_id', referencedColumnName: 'id')]
    private ConversationSettings $settings;

    #[ManyToMany(targetEntity: User::class, inversedBy: 'conversations')]
    #[JoinTable(name: 'conversation_user')]
    private Collection $users;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function setMessages(Collection $messages): Conversation
    {
        $this->messages = $messages;
        return $this;
    }

    public function getSettings(): ConversationSettings
    {
        return $this->settings;
    }

    public function setSettings(ConversationSettings $settings): Conversation
    {
        $this->settings = $settings;
        return $this;
    }

    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function setUsers(Collection $users): Conversation
    {
        $this->users = $users;
        return $this;
    }
}
