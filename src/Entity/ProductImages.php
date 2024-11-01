<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductImagesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductImagesRepository::class)]
#[ORM\Table(options: ["comment" => 'Products images'])]
#[ORM\HasLifecycleCallbacks]
class ProductImages
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'productImages')]
    private ?Product $Product = null;

    #[ORM\Column(nullable: true,options: ["comment" => 'Is MAIN image flag'])]
    private ?bool $Main = null;

	#[ORM\OneToOne(cascade: ['persist', 'remove'])]
	private ?Files $ImageFile = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
        return $this->id;
    }


    public function isMain(): ?bool
    {
        return $this->Main;
    }

    public function setMain(?bool $Main): static
    {
        $this->Main = $Main;

        return $this;
    }

	/**
	 * @return Product|null
	 */
	public function getProduct(): ?Product {
		return $this->Product;
	}

	/**
	 * @param Product|null $Product
	 */
	public function setProduct(?Product $Product): void {
		$this->Product = $Product;
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

	public function getImageFile(): ?Files
	{
		return $this->ImageFile;
	}

	public function setImageFile(?Files $ImageFile): static
	{
		$this->ImageFile = $ImageFile;

		return $this;
	}
}
