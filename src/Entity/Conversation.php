<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
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

    #[OneToMany(targetEntity: Message::class, mappedBy: 'conversation', cascade: ['persist'])]
    private Collection $messages;

    #[OneToOne(targetEntity: ConversationSetting::class, cascade: ['persist'])]
    #[JoinColumn(name: 'settings_id', referencedColumnName: 'id')]
    private ConversationSetting $setting;

    #[OneToMany(targetEntity: ConversationUser::class, mappedBy: 'conversation', cascade: ['persist'])]
    private Collection $conversationUsers;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->conversationUsers = new ArrayCollection();
    }

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

    public function getSetting(): ConversationSetting
    {
        return $this->setting;
    }

    public function setSetting(ConversationSetting $setting): Conversation
    {
        $this->setting = $setting;
        return $this;
    }

    public function getConversationUsers(): Collection
    {
        return $this->conversationUsers;
    }

    public function setConversationUsers(Collection $conversationUsers): Conversation
    {
        $this->conversationUsers = $conversationUsers;
        return $this;
    }

    public function addConversationUser(ConversationUser $conversationUser): Conversation
    {
        $this->conversationUsers->add($conversationUser);

        return $this;
    }
}
