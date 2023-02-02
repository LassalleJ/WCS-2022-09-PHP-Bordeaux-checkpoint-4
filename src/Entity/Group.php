<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GroupRepository::class)]
#[ORM\Table(name: '`group`')]
class Group
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isFull = null;

    #[ORM\OneToMany(mappedBy: 'fromGroup', targetEntity: Invitation::class)]
    private Collection $invitations;

    #[ORM\OneToMany(mappedBy: 'inGroup', targetEntity: Character::class)]
    private Collection $characters;

    #[ORM\OneToMany(mappedBy: 'party', targetEntity: Message::class)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'inParty', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->invitations = new ArrayCollection();
        $this->characters = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->setCreatedAt(new DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function isIsFull(): ?bool
    {
        return $this->isFull;
    }

    public function setIsFull(?bool $isFull): self
    {
        $this->isFull = $isFull;

        return $this;
    }

    /**
     * @return Collection<int, Invitation>
     */
    public function getInvitations(): Collection
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations->add($invitation);
            $invitation->setFromGroup($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getFromGroup() === $this) {
                $invitation->setFromGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Character>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(Character $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters->add($character);
            $character->setInGroup($this);
        }

        return $this;
    }

    public function removeCharacter(Character $character): self
    {
        if ($this->characters->removeElement($character)) {
            // set the owning side to null (unless already changed)
            if ($character->getInGroup() === $this) {
                $character->setInGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setParty($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getParty() === $this) {
                $message->setParty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setInParty($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getInParty() === $this) {
                $user->setInParty(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTank(): ?Character
    {
        foreach ($this->characters as $char) {
            if ($char->getRole() === 'Tank') {
                return $char;
            }
        }
        return null;
    }

    public function getHealer(): ?Character
    {
        foreach ($this->characters as $char) {
            if ($char->getRole() === 'Healer') {
                return $char;
            }
        }
        return null;
    }

    public function getDamageDealer(): ?array
    {
        $arrayChar=[];
        foreach ($this->characters as $char) {
            if ($char->getRole() === 'Damage Dealer') {
                $arrayChar[]=$char;
            }
        }
        return $arrayChar;
    }
}
