<?php
/**
 * User: smerteliko
 * Date: 30.07.2024
 * Time: 16:24
 */

namespace App\Service\Admin;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\MappingException;
use Symfony\Contracts\Service\Attribute\Required;

class Entities {

	private array                  $entities;

	private array $entitiesNames;
	private array $mappingErrors = [];

	public function __construct(
		private readonly EntityManagerInterface $entityManager) {
	}

	#[Required]
	public function setEntities(): void {
		$this->entitiesNames = $this->entityManager->getConfiguration()
		                                           ->getMetadataDriverImpl()?->getAllClassNames() ?: [];
		foreach ($this->entitiesNames as $entityName) {
			$this->entities[$entityName] = $this->entityManager->getClassMetadata($entityName);
		}
	}

	#[Required]
	public function checkMapping(): void {
		foreach($this->entitiesNames as $entity) {
			try {
				$this->entityManager->getClassMetadata($entity);
				$this->mappingErrors[$entity] = TRUE;
			} catch (MappingException $exception) {
				$this->mappingErrors[$entity] = $exception->getMessage();
			}
		}
	}

	public function getMappingErrors(): array {
		return $this->mappingErrors;
	}

	public function getEntities(): array {
		return $this->entities;
	}
}