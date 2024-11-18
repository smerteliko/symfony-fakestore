<?php

namespace App\Entity;

use App\Repository\UserVerificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserVerificationRepository::class)]
#[ORM\Table(options: ["comment" => 'User verification codes table'])]
#[ORM\HasLifecycleCallbacks]
class UserVerification
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(length: 255, options: ["comment" => 'Verification code'])]
    private ?string $Code = null;

    #[ORM\OneToOne(inversedBy: 'VerificationCode', cascade: ['persist'])]
    private ?User $verificationUser = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
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

	public function getCreatedAt(): ?\DateTimeImmutable
	{
		return $this->created_at;
	}

	public function setCreatedAt(): static
	{
		$this->created_at = new \DateTimeImmutable();

		return $this;
	}

	public function getUpdatedAt(): ?\DateTimeImmutable
	{
		return $this->updated_at;
	}

	#[ORM\PreFlush]
	public function setUpdatedAt(): static
	{
		$this->updated_at = new \DateTimeImmutable();

		return $this;
	}
}
