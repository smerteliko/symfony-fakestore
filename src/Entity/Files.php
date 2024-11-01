<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
#[ORM\Table(options: ["comment" => 'Files list (user avatar, product images, etc)'])]
#[ORM\HasLifecycleCallbacks]
class Files
{
	#[ORM\Id]
	#[ORM\Column(type: UuidType::NAME, unique: true)]
	#[ORM\GeneratedValue(strategy: 'CUSTOM')]
	#[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
	private ?Uuid $id = null;

    #[ORM\Column(length: 255,options: ["comment" => 'File original name'])]
    private ?string $OriginalName = null;

    #[ORM\Column(length: 512, options: ["comment" => 'File asset name'])]
    private ?string $FileName = null;

    #[ORM\Column(length: 255, options: ["comment" => 'File type'])]
    private ?string $Type = null;

    #[ORM\Column(length: 8, options: ["comment" => 'File extension'])]
    private ?string $Ext = null;

    #[ORM\Column(options: ["comment" => 'File size'])]
    private ?int $Size = null;


	#[ORM\Column]
	private ?\DateTimeImmutable $created_at = null;

	#[ORM\Column(nullable: true)]
	private ?\DateTimeImmutable $updated_at = null;

    public function getId(): Uuid {
        return $this->id;
    }

    public function getOriginalName(): ?string
    {
        return $this->OriginalName;
    }

    public function setOriginalName(string $OriginalName): static
    {
        $this->OriginalName = $OriginalName;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->FileName;
    }

    public function setFileName(string $FileName): static
    {
        $this->FileName = $FileName;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getExt(): ?string
    {
        return $this->Ext;
    }

    public function setExt(string $Ext): static
    {
        $this->Ext = $Ext;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->Size;
    }

    public function setSize(int $Size): static
    {
        $this->Size = $Size;

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
