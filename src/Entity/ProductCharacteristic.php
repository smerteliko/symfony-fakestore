<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductCharacteristicRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductCharacteristicRepository::class)]
#[ORM\Table(options: ["comment" => 'Currency list'])]
#[ORM\HasLifecycleCallbacks]
class ProductCharacteristic
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\OneToOne(inversedBy: 'productCharacteristic', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    #[ORM\Column(nullable: true,options: ["comment" => 'Characteristic as JSON'])]
    private ?array $Data = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
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
