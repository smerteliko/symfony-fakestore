<?php

namespace App\Entity;

use App\Repository\ProductDescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductDescriptionRepository::class)]
class ProductDescription
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $BriefDesc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $FullDescription = null;

    #[ORM\OneToOne(inversedBy: 'productDescription', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBriefDesc(): ?string
    {
        return $this->BriefDesc;
    }

    public function setBriefDesc(?string $BriefDesc): static
    {
        $this->BriefDesc = $BriefDesc;

        return $this;
    }

    public function getFullDescription(): ?string
    {
        return $this->FullDescription;
    }

    public function setFullDescription(?string $FullDescription): static
    {
        $this->FullDescription = $FullDescription;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}
