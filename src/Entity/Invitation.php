<?php

namespace App\Entity;

use App\Repository\InvitationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvitationRepository::class)]
class Invitation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'invitations')]
    private ?Group $fromGroup = null;

    #[ORM\OneToOne(mappedBy: 'invitation', cascade: ['persist', 'remove'])]
    private ?Notification $notification = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFromGroup(): ?Group
    {
        return $this->fromGroup;
    }

    public function setFromGroup(?Group $fromGroup): self
    {
        $this->fromGroup = $fromGroup;

        return $this;
    }

    public function getNotification(): ?Notification
    {
        return $this->notification;
    }

    public function setNotification(?Notification $notification): self
    {
        // unset the owning side of the relation if necessary
        if ($notification === null && $this->notification !== null) {
            $this->notification->setInvitation(null);
        }

        // set the owning side of the relation if necessary
        if ($notification !== null && $notification->getInvitation() !== $this) {
            $notification->setInvitation($this);
        }

        $this->notification = $notification;

        return $this;
    }
}
