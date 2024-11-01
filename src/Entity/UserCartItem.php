<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserCartItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserCartItemRepository::class)]
#[ORM\Table(options: ["comment" => 'User cart item to product table'])]
#[ORM\HasLifecycleCallbacks]
class UserCartItem
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(nullable: true, options: ["comment" => 'Cart item quantity'])]
    private ?int $quantity = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Product $cartItemProduct = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'userCartItem')]
    private ?UserCart $userCart = null;


	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCartItemProduct(): ?Product
    {
        return $this->cartItemProduct;
    }

    public function setCartItemProduct(?Product $cartItemProduct): static
    {
        $this->cartItemProduct = $cartItemProduct;

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

    public function getUserCart(): ?UserCart
    {
        return $this->userCart;
    }

    public function setUserCart(?UserCart $userCart): static
    {
        $this->userCart = $userCart;

        return $this;
    }
}
