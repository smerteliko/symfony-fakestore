<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ProductImages;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductImages>
 *
 * @method ProductImages|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductImages|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductImages[]    findAll()
 * @method ProductImages[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductImagesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductImages::class);
    }

    final public function findProductImagesBy(array $options): array
    {
        $qb = $this->getEntityManager()
                   ->createQueryBuilder()
                   ->select('productImages')
                   ->from(ProductImages::class, 'productImages');

        if ($options['prodId']) {
            $qb->where('productImages.Product = :id')
                ->setParameter('id', $options['prodId']);
        }

        return $qb->getQuery()->getArrayResult();
    }
}
