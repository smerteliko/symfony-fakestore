<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserCartItemRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCartItemRepository::class)]
class UserCartItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $quantity = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Product $cartItemProduct = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(inversedBy: 'userCartItem')]
    private ?UserCart $userCart = null;

    public function getId(): ?int
    {
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

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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
