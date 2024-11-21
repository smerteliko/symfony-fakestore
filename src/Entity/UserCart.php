<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserCartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UserCartRepository::class)]
#[ORM\Table(options: ["comment" => 'User cart table'])]
#[ORM\HasLifecycleCallbacks]
class UserCart
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCarts')]
    private ?User $appliesTo = null;

    /**
     * @var Collection<int, UserCartItem>
     */
    #[ORM\OneToMany(targetEntity: UserCartItem::class, mappedBy: 'userCart', cascade: ['persist','remove'])]
    private Collection $userCartItem;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->userCartItem = new ArrayCollection();
    }

    public function getId(): Uuid {
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
