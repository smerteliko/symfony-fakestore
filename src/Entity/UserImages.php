<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserImagesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class UserImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'userImages', cascade: ['persist', 'remove'])]
    private ?User $ImageUser = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Files $ImageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUser(): ?User
    {
        return $this->ImageUser;
    }

    public function setImageUser(?User $ImageUser): static
    {
        $this->ImageUser = $ImageUser;

        return $this;
    }

    public function getImageFile(): ?Files
    {
        return $this->ImageFile;
    }

    public function setImageFile(?Files $ImageFile): static
    {
        $this->ImageFile = $ImageFile;

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
