<?php

namespace App\Entity;

use App\Repository\CurRatesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CurRatesRepository::class)]
#[ORM\HasLifecycleCallbacks]
class CurRates
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $Rate = null;

    #[ORM\Column(nullable: true)]
    private ?float $unitRate = null;

	#[Assert\Currency]
    #[ORM\OneToOne(targetEntity: Currency::class,inversedBy: 'rates')]
    #[ORM\JoinColumn(name:'IsoCode',referencedColumnName: 'IsoCode',nullable: true)]
    private ?Currency $Currency;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getId(): ?int
    {
        return $this->id;
    }


    public function getRate(): ?float
    {
        return $this->Rate;
    }

    public function setRate(?float $Rate): static
    {
        $this->Rate = $Rate;

        return $this;
    }

    public function getUnitRate(): ?float
    {
        return $this->unitRate;
    }

    public function setUnitRate(?float $unitRate): static
    {
        $this->unitRate = $unitRate;

        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->Currency;
    }

    public function setCurrency(Currency $Currency): static
    {
        $this->Currency = $Currency;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

	#[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }
}
