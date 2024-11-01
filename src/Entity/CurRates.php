<?php

namespace App\Entity;

use App\Repository\CurRatesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CurRatesRepository::class)]
#[ORM\Table(name: 'cur_rates', options: ["comments" => 'Currency rates table'])]
#[ORM\HasLifecycleCallbacks]
class CurRates
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(nullable: true ,options: ["comment" => 'Currency rate value'])]
    private ?float $Rate = null;

    #[ORM\Column(nullable: true, options: ["comment" => 'Currency unit rate value'])]
    private ?float $unitRate = null;



	#[Assert\Currency]
    #[ORM\OneToOne(targetEntity: Currency::class,inversedBy: 'rates')]
    #[ORM\JoinColumn(name:'IsoCode',referencedColumnName: 'IsoCode',nullable: true)]
    private ?Currency $Currency;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;


    public function getId(): Uuid {
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
