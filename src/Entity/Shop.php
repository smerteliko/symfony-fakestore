<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ShopRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ShopRepository::class)]
#[ORM\Table(options: ["comment" => 'Shops'])]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class Shop
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(length: 255,options: ["comment" => 'Shop name'])]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true,options: ["comment" => 'Shop brief description'])]
    private ?string $DescriptionBrief = null;

    #[ORM\Column(length: 511, nullable: true, options: ["comment" => 'Shop full description'])]
    private ?string $Description = null;


    /**
     * @var Collection<int, Product>
     */
    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'shop', cascade: ['persist', 'remove'])]
    private Collection $Products;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'shop', cascade: ['persist', 'remove'])]
    private Collection $Users;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
        $this->Products = new ArrayCollection();
    }

    public function getId(): Uuid {
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

    public function getDescriptionBrief(): ?string
    {
        return $this->DescriptionBrief;
    }

    public function setDescriptionBrief(?string $DescriptionBrief): static
    {
        $this->DescriptionBrief = $DescriptionBrief;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }


    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
            $product->setShop($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->Products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getShop() === $this) {
                $product->setShop(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $user): static
    {
        if (!$this->Users->contains($user)) {
            $this->Users->add($user);
            $user->setShop($this);
        }

        return $this;
    }

    public function removeUser(User $User): static
    {
        if ($this->Users->removeElement($User)) {
            // set the owning side to null (unless already changed)
            if ($User->getShop() === $this) {
                $User->setShop(null);
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
