<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ProductDescriptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ProductDescriptionRepository::class)]
#[ORM\Table(options: ["comment" => 'Products descriptions'])]
#[ORM\HasLifecycleCallbacks]
class ProductDescription
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(length: 255, nullable: true, options: ["comment" => 'Products brief description'])]
    private ?string $BriefDesc = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ["comment" => 'Products description full text'])]
    private ?string $FullDescription = null;

    #[ORM\OneToOne(inversedBy: 'productDescription', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
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
