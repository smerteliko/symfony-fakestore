<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $Category = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'Product')]
    private ?SubCategory $subCategory = null;

    /**
     * @var Collection<int, ProductImages>
     */
    #[ORM\OneToMany(targetEntity: ProductImages::class, mappedBy: 'Product')]
    private Collection $productImages;

    #[ORM\OneToOne(mappedBy: 'product', cascade: ['persist', 'remove'])]
    private ?ProductDescription $productDescription = null;

    #[ORM\OneToOne(mappedBy: 'product', cascade: ['persist', 'remove'])]
    private ?ProductCharacteristic $productCharacteristic = null;

    public function __construct()
    {
        $this->productImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->Category = $Category;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getSubCategory(): ?SubCategory
    {
        return $this->subCategory;
    }

    public function setSubCategory(?SubCategory $subCategory): static
    {
        $this->subCategory = $subCategory;

        return $this;
    }

    /**
     * @return Collection<int, ProductImages>
     */
    public function getProductImages(): Collection
    {
        return $this->productImages;
    }

    public function addProductImage(ProductImages $productImage): static
    {
        if (!$this->productImages->contains($productImage)) {
            $this->productImages->add($productImage);
            $productImage->setProductID($this);
        }

        return $this;
    }

    public function removeProductImage(ProductImages $productImage): static
    {
        if ($this->productImages->removeElement($productImage)) {
            // set the owning side to null (unless already changed)
            if ($productImage->getProductID() === $this) {
                $productImage->setProductID(null);
            }
        }

        return $this;
    }

    public function getProductDescription(): ?ProductDescription
    {
        return $this->productDescription;
    }

    public function setProductDescription(?ProductDescription $productDescription): static
    {
        // unset the owning side of the relation if necessary
        if (null === $productDescription && null !== $this->productDescription) {
            $this->productDescription->setProduct(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $productDescription && $productDescription->getProduct() !== $this) {
            $productDescription->setProduct($this);
        }

        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductCharacteristic(): ?ProductCharacteristic
    {
        return $this->productCharacteristic;
    }

    public function setProductCharacteristic(?ProductCharacteristic $productCharacteristic): static
    {
        // unset the owning side of the relation if necessary
        if (null === $productCharacteristic && null !== $this->productCharacteristic) {
            $this->productCharacteristic->setProduct(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $productCharacteristic && $productCharacteristic->getProduct() !== $this) {
            $productCharacteristic->setProduct($this);
        }

        $this->productCharacteristic = $productCharacteristic;

        return $this;
    }

    public function toArray(): array
    {
        $rtrnData = [
            'id' => $this->getId(),
            'Name' => $this->getName(),
            'Category' => $this->getCategory()->getName(),
            'price' => $this->getPrice(),
            'created_at' => $this->getCreatedAt(),
            'subCategory' => $this->getSubCategory()->getName(),
        ];

        if ($this->getProductCharacteristic()) {
            $rtrnData['productCharacteristic'] = [
                'id' => $this->getProductCharacteristic()->getId(),
                'data' => $this->getProductCharacteristic()->getData(),
            ];
        }

        if ($this->getProductDescription()) {
            $rtrnData['productDescription'] = [
                'id' => $this->getProductDescription()->getId(),
                'BriefDesc' => $this->getProductDescription()->getBriefDesc(),
                'FullDescription' => $this->getProductDescription()->getFullDescription(),
            ];
        }

        return $rtrnData;
    }
}
