<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`',options: ["comment" => 'Users'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_UUID', fields: ['id'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(options: ["comment" => 'User system roles'])]
    private array $roles = [];

    /**
     * @var ?string The hashed password
     */
	#[Assert\NotBlank]
    #[ORM\Column(options: ["comment" => 'User password'])]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updated_at = null;

    /**
     * @var Collection<int, UserCart>
     */
    #[ORM\OneToMany(targetEntity: UserCart::class, mappedBy: 'appliesTo')]
    private Collection $userCarts;

	#[Assert\Email(
       message: 'The email {{ value }} is not a valid email.',
    )]
    #[Assert\NotBlank]
	#[ORM\Column(length: 255, options: ["comment" => 'User email'])]
	private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true,options: ["comment" => 'User first name'])]
    private ?string $FirstName = null;

    #[ORM\Column(length: 255, nullable: true, options: ["comment" => 'User last name'])]
    private ?string $LastName = null;

	#[Assert\NotBlank]
	#[ORM\Column(length: 255, nullable: true, options: ["comment" => 'User phone number'])]
	private ?string $Phone = null;

    #[ORM\Column(length: 255, nullable: true, options: ["comment" => 'User system language'])]
    private ?string $Language = null;

    #[ORM\ManyToOne(targetEntity: Currency::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name:'IsoCode',referencedColumnName: 'IsoCode',nullable: true)]
    private ?Currency $Currency = null;
    #[ORM\OneToOne(mappedBy: 'ImageUser', cascade: ['persist', 'remove'])]
    private ?UserImages $userImages = null;

    #[ORM\OneToOne(mappedBy: 'verificationUser', cascade: ['persist', 'remove'])]
    private ?UserVerification $VerificationCode = null;

    #[ORM\Column(options: ["comment" => 'If user verified flag'])]
    private ?bool $isVerified = false;

    #[ORM\Column(options: ["comment" => 'User enabled flag'])]
    private ?bool $enabled = true;

	#[ORM\ManyToOne(inversedBy: 'Shop')]
	private Shop $shop;
    public function __construct()
    {
        $this->userCarts = new ArrayCollection();
    }

    public function getId(): Uuid {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    /**
     * @return Collection<int, UserCart>
     */
    public function getUserCarts(): Collection
    {
        return $this->userCarts;
    }

    public function addUserCart(UserCart $userCart): static
    {
        if (!$this->userCarts->contains($userCart)) {
            $this->userCarts->add($userCart);
            $userCart->setAppliesTo($this);
        }

        return $this;
    }

    public function removeUserCart(UserCart $userCart): static
    {
        if ($this->userCarts->removeElement($userCart)) {
            // set the owning side to null (unless already changed)
            if ($userCart->getAppliesTo() === $this) {
                $userCart->setAppliesTo(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->FirstName;
    }

    public function setFirstName(?string $FirstName): static
    {
        $this->FirstName = $FirstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(?string $LastName): static
    {
        $this->LastName = $LastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->Phone;
    }

    public function setPhone(?string $Phone): static
    {
        $this->Phone = $Phone;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->Language;
    }

    public function setLanguage(?string $Language): static
    {
        $this->Language = $Language;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->Currency;
    }

    public function setCurrency(?Currency $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getUserImages(): ?UserImages
    {
        return $this->userImages;
    }

    public function setUserImages(?UserImages $userImages): static
    {
        // unset the owning side of the relation if necessary
        if (null === $userImages && null !== $this->userImages) {
            $this->userImages->setImageUser(null);
        }

        // set the owning side of the relation if necessary
        if (null !== $userImages && $userImages->getImageUser() !== $this) {
            $userImages->setImageUser($this);
        }

        $this->userImages = $userImages;

        return $this;
    }

    public function getVerificationCode(): ?UserVerification
    {
        return $this->VerificationCode;
    }

    public function setVerificationCode(?UserVerification $VerificationCode): static
    {
        // unset the owning side of the relation if necessary
        if ($VerificationCode === null && $this->VerificationCode !== null) {
            $this->VerificationCode->setVerificationUser(null);
        }

        // set the owning side of the relation if necessary
        if ($VerificationCode !== null && $VerificationCode->getVerificationUser() !== $this) {
            $VerificationCode->setVerificationUser($this);
        }

        $this->VerificationCode = $VerificationCode;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setVerified(bool $isVerified = false): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

	/**
	 * @return static
	 */
	public function verify(): self
	{
		$this->setVerified(true);

		if (!in_array('ROLE_VERIFIED_USER', $this->roles, true)) {
			$this->roles[] = 'ROLE_VERIFIED_USER';
		}

		return $this;
	}

	/**
	 * @return static
	 */
	public function unverify(): self
	{
		$this->setVerified(false);

		if (in_array('ROLE_VERIFIED_USER', $this->roles, true)) {
			// Ensure there are no duplicates AND no holes in array keys
			$tempRoles = [];
			foreach ($this->roles as $role) {
				if ($role !== 'ROLE_VERIFIED_USER' && !in_array($role, $tempRoles)) {
					$tempRoles[] = $role;
				}
			}
			$this->roles[] = $tempRoles;
		}

		return $this;
	}

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled = true): static
    {
        $this->enabled = $enabled;

        return $this;
    }

	public function getShop(): ?Shop
	{
		return $this->shop;
	}

	public function setShop(?Shop $shop): static
	{
		$this->shop = $shop;

		return $this;
	}

	public function toArray(): array
	{
		$rtrnArray = [
			'id' => $this->id,
			'email' => $this->email,
			'FirstName' => $this->FirstName,
			'LastName' => $this->LastName,
			'phone' => $this->Phone,
			'language' => $this->Language,
			'isVerified' => $this->isVerified,
			'enabled' => $this->enabled,
			'roles' => $this->roles,
		];

		if ($this->Currency) {
			$rtrnArray['currency'] = [
				'Name' => $this->Currency->getName(),
				'Symbol' => $this->Currency->getSymbol(),
				'IsoCode' => $this->Currency->getIsoNumCode(),
				'ISOCharCode' => $this->Currency->getISOCharCode(),
			];
		}

		if ($this->userImages) {
			$rtrnArray['Images'] = [
				'id' => $this->userImages->getId(),
				'updatedAt' => $this->userImages->getUpdatedAt(),
				'createdAt' => $this->userImages->getCreatedAt(),
			];
			if ($this->userImages->getImageFile()) {
				$rtrnArray['Images']['file'] = [
					'id' => $this->userImages->getImageFile()->getId(),
					'FileName' => $this->userImages->getImageFile()->getFilename(),
					'Type' => $this->userImages->getImageFile()->getType(),
					'Size' => $this->userImages->getImageFile()->getSize(),
				];
			}
		}

		if ($this->VerificationCode) {
			$rtrnArray['verificationCode'] = [
				'id' => $this->VerificationCode->getId(),
				'code' => $this->VerificationCode->getCode(),

			];
		}

		return $rtrnArray;
	}
}
