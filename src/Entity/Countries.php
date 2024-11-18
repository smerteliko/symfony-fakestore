<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\CountriesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: CountriesRepository::class)]
#[ORM\Table(name: 'Countries', options: ["comment" => 'Countries table'])]
#[ORM\HasLifecycleCallbacks]
#[ApiResource(
	options: [
		new Get(),
		new GetCollection()
	]
)]
class Countries
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

	/**
	 * Country abbr
	 * @var string|null
	 */
    #[ORM\Column(length: 3, nullable: true,options: ["comment" => 'Country abbr'])]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true,options: ["comment" => 'Country name'])]
    private ?string $name = null;

    #[ORM\Column(length: 4, options: ["comment" => 'Country phone code'])]
    private int $phone_code;

	/**
	 * /currency/{isocode}
	 * @var Currency|null
	 */
    #[ORM\ManyToOne( cascade: [ 'persist'], inversedBy: 'country' )]
    #[ORM\JoinColumn(name:'currency_iso_code',referencedColumnName: 'IsoCode',nullable: true)]
    private ?Currency $currency_iso_code = null;

    #[ORM\Column(length: 255, nullable: true ,options: ["comment" => 'Country continent name'])]
    private ?string $continent = null;

    #[ORM\Column(length: 255, nullable: true, options: ["comment" => 'Country continent code'])]
    private ?string $continent_code = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPhoneCode(): ?string
    {
        return $this->phone_code;
    }

    public function setPhoneCode(?string $phone_code): static
    {
        $this->phone_code = $phone_code;

        return $this;
    }

    public function getCurrencyIsoCode(): ?Currency
    {
        return $this->currency_iso_code;
    }

    public function setCurrencyIsoCode(?Currency $currency_iso_code): static
    {
        $this->currency_iso_code = $currency_iso_code;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(?string $continent): static
    {
        $this->continent = $continent;

        return $this;
    }

    public function getContinentCode(): ?string
    {
        return $this->continent_code;
    }

    public function setContinentCode(?string $continent_code): static
    {
        $this->continent_code = $continent_code;

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
