<?php

namespace App\Entity;

use App\Repository\ProductImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductImagesRepository::class)]
class ProductImages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    private ?Product $Product = null;

    #[ORM\Column(length: 255)]
    private ?string $FileNameBase = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->ProductID;
    }

    public function setProductID(?Product $ProductID): static
    {
        $this->ProductID = $ProductID;

        return $this;
    }

    public function getFileNameBase(): ?string
    {
        return $this->FileNameBase;
    }

    public function setFileNameBase(string $FileNameBase): static
    {
        $this->FileNameBase = $FileNameBase;

        return $this;
    }
}
