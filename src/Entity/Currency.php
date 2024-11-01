<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
#[ORM\Table(options: ["comment" => 'Currency list'])]
#[ORM\HasLifecycleCallbacks]
class Currency
{

    #[ORM\Column(length: 128,options: ["comment" => 'Currency name'])]
    private ?string $Name = null;

    #[ORM\Column( length: 5, nullable: true ,options: ["comment" => 'Currency ISO char code'])]
    private ?string $ISOCharCode = null;

    #[ORM\Column(length: 30, nullable: true,options: ["comment" => 'Currency ISO symbol'])]
    private ?string $Symbol = null;
	#[ORM\OneToOne(targetEntity: CurRates::class,mappedBy: 'Currency')]
	private ?CurRates $rates;

	#[Assert\Currency]
	#[Assert\NotBlank]
	#[ORM\Id]
	#[ORM\GeneratedValue(strategy:"NONE")]
	#[ORM\Column(name: 'IsoCode',length: 5,unique: true,options: ["comment" => 'Currency ISO num code (all unique)'])]
	private string $IsoCode;

    /**
     * @var Collection<int, Countries>
     */
    #[ORM\OneToMany(targetEntity: Countries::class, mappedBy: 'currency_iso_code')]
    private Collection $country;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->country = new ArrayCollection();
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


    public function getSymbol(): ?string
    {
        return $this->Symbol;
    }

    public function setSymbol(?string $Symbol): static
    {
        $this->Symbol = $Symbol;

        return $this;
    }


	public function setIsoNumCode(string $IsoNumCode): void {
		$this->IsoCode = $IsoNumCode;
	}

	public function getIsoNumCode(): string {
		return $this->IsoCode;
	}

	public function setISOCharCode(?string $ISOCharCode): void {
		$this->ISOCharCode = $ISOCharCode;
	}

	public function getISOCharCode(): ?string {
		return $this->ISOCharCode;
	}

    /**
     * @return Collection<int, Countries>
     */
    public function getCountry(): Collection
    {
        return $this->country;
    }

    public function addCountry(Countries $country): static
    {
        if (!$this->country->contains($country)) {
            $this->country->add($country);
            $country->setCurrencyIsoCode($this);
        }

        return $this;
    }

    public function removeCountry(Countries $country): static
    {
        if ($this->country->removeElement($country)) {
            // set the owning side to null (unless already changed)
            if ($country->getCurrencyIsoCode() === $this) {
                $country->setCurrencyIsoCode(null);
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

	public function getRates(): ?CurRates
	{
		return $this->rates;
	}

	public function setRates(?CurRates $rates): static
	{
		// unset the owning side of the relation if necessary
		if (null === $rates && null !== $this->rates) {
			$this->rates->setRate(null);
		}

		// set the owning side of the relation if necessary
		if (null !== $rates && $rates->getCurrency() !== $this) {
			$rates->setCurrency($this);
		}

		$this->rates = $rates;

		return $this;
	}

}
