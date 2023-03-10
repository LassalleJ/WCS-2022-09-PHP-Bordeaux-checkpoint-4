<?php

namespace App\Entity;

use App\Repository\SpecificityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpecificityRepository::class)]
class Specificity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'specificity', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $playingWay = null;

    #[ORM\Column(nullable: true)]
    private ?bool $roleFlexibility = null;

    #[ORM\Column(nullable: true)]
    private ?bool $classFlexibility = null;

    #[ORM\Column(nullable: true)]
    private ?bool $speakEnglish = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPlayingWay(): ?string
    {
        return $this->playingWay;
    }

    public function setPlayingWay(?string $playingWay): self
    {
        $this->playingWay = $playingWay;

        return $this;
    }

    public function isRoleFlexibility(): ?bool
    {
        return $this->roleFlexibility;
    }

    public function setRoleFlexibility(?bool $roleFlexibility): self
    {
        $this->roleFlexibility = $roleFlexibility;

        return $this;
    }

    public function isClassFlexibility(): ?bool
    {
        return $this->classFlexibility;
    }

    public function setClassFlexibility(?bool $classFlexibility): self
    {
        $this->classFlexibility = $classFlexibility;

        return $this;
    }

    public function isSpeakEnglish(): ?bool
    {
        return $this->speakEnglish;
    }

    public function setSpeakEnglish(?bool $speakEnglish): self
    {
        $this->speakEnglish = $speakEnglish;

        return $this;
    }
}
