<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRepository::class)]
class Currency
{
    #[ORM\GeneratedValue(strategy: 'SEQUENCE')]
    #[ORM\Column(nullable: true)]
    private int $id;

    #[ORM\Column(length: 128)]
    private ?string $Name = null;

    #[ORM\Column(length: 5, nullable: true)]
    private ?string $ISOCharCode = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $Symbol = null;
	#[ORM\OneToOne(targetEntity: CurRates::class,mappedBy: 'Currency')]
	private ?CurRates $rates;

	#[ORM\Column(name: 'IsoCode',length: 5)]
	#[ORM\Id]
    private string $IsoCode;



	public function getId(): ?int
    {
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

}
