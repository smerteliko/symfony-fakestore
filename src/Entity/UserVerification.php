<?php

namespace App\Entity;

use App\Repository\UserVerificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserVerificationRepository::class)]
class UserVerification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Code = null;

    #[ORM\OneToOne(inversedBy: 'VerificationCode', cascade: ['persist', 'remove'])]
    private ?User $verificationUser = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->Code;
    }

    public function setCode(string $Code): static
    {
        $this->Code = $Code;

        return $this;
    }

    public function getVerificationUser(): ?User
    {
        return $this->verificationUser;
    }

    public function setVerificationUser(?User $verificationUser): static
    {
        $this->verificationUser = $verificationUser;

        return $this;
    }
}
