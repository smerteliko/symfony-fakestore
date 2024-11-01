<?php

namespace App\Entity;

use App\Repository\ProductPriceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductPriceRepository::class)]
#[ORM\Table(options: ["comment" => 'Products prices'])]
#[ORM\HasLifecycleCallbacks]
class ProductPrice
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(options: ["comment" => 'Product price'])]
    private ?float $price = null;

    #[ORM\OneToOne(inversedBy: 'productPrice', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    #[ORM\Column(nullable: true, options: ["comment" => 'Product VAT percent'])]
    private ?float $VAT = null;

    #[ORM\Column(nullable: true, options: ["comment" => 'Product discount percent'])]
    private ?float $discount = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'IsoCode',referencedColumnName: 'IsoCode',nullable: true)]
    private ?Currency $currency = null;

	    #[ORM\Column]
	    private ?\DateTimeImmutable $createdAt = null;

	    #[ORM\Column]
	    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): Uuid {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

    public function getVAT(): ?float
    {
        return $this->VAT;
    }

    public function setVAT(?float $VAT): static
    {
        $this->VAT = $VAT;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(?float $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): static
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

	#[ORM\PrePersist]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
