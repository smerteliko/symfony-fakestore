<?php

namespace App\Entity;

use App\Repository\UserCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserCartRepository::class)]
class UserCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCarts')]
    private ?User $appliesTo = null;

    /**
     * @var Collection<int, UserCartItem>
     */
    #[ORM\OneToMany(targetEntity: UserCartItem::class, mappedBy: 'userCart')]
    private Collection $userCartItem;

    public function __construct()
    {
        $this->userCartItem = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAppliesTo(): ?User
    {
        return $this->appliesTo;
    }

    public function setAppliesTo(?User $appliesTo): static
    {
        $this->appliesTo = $appliesTo;

        return $this;
    }

    /**
     * @return Collection<int, UserCartItem>
     */
    public function getUserCartItem(): Collection
    {
        return $this->userCartItem;
    }

    public function addUserCartItem(UserCartItem $userCartItem): static
    {
        if (!$this->userCartItem->contains($userCartItem)) {
            $this->userCartItem->add($userCartItem);
            $userCartItem->setUserCart($this);
        }

        return $this;
    }

    public function removeUserCartItem(UserCartItem $userCartItem): static
    {
        if ($this->userCartItem->removeElement($userCartItem)) {
            // set the owning side to null (unless already changed)
            if ($userCartItem->getUserCart() === $this) {
                $userCartItem->setUserCart(null);
            }
        }

        return $this;
    }
}
