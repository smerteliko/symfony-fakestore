<?php

namespace App\Entity;

use App\Repository\ProductCharacteristicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductCharacteristicRepository::class)]
class ProductCharacteristic
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'productCharacteristic', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    #[ORM\Column(nullable: true)]
    private ?array $Data = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getData(): ?array
    {
        return $this->Data;
    }

    public function setData(?array $Data): static
    {
        $this->Data = $Data;

        return $this;
    }
}
