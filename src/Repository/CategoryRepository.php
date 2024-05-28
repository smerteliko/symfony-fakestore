<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit= null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    private CacheInterface $cache;

    public function __construct(ManagerRegistry $registry, CacheInterface $cache)
    {
        parent::__construct($registry, Category::class);
        $this->cache = $cache;
    }

    public function newCategory($data): void
    {
        $category = new Category();
        $category->setName($data['Name']);

        if ('' !== trim($data['Description'])) {
            $category->setDescriprion($data['Description']);
        }

        $category->setCreatedAt(new \DateTimeImmutable());

        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getAllCategoriesCached(): mixed
    {
        return $this->cache->get('CategoriesList', function (ItemInterface $item) {
            return $this->getEntityManager()
                        ->createQueryBuilder()
                        ->select('category', 'sub')
                        ->from(Category::class, 'category')
                        ->leftJoin('category.subCategories', 'sub')
                        ->orderBy('category.id', 'ASC')
                        ->getQuery()
                        ->getArrayResult()
            ;
        });
    }

    public function findCategoriesBy(array $options): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('category')
            ->from(Category::class, 'category');

        if ($options['id']) {
            $qb->where('category.id = :id');
            $qb->setParameter('id', $options['id']);
        }

        if ($options['withSubs']) {
            $qb->addSelect('sub');
            $qb->leftJoin('category.subCategories', 'sub');
        }

        return $qb->getQuery()->getArrayResult();
    }

    public function findAllCatArray(): array
    {
        return $this->getEntityManager()
                    ->createQueryBuilder()
                    ->select('category', 'sub')
                    ->from(Category::class, 'category')
                    ->leftJoin('category.subCategories', 'sub')
                    ->orderBy('category.id', 'ASC')
                    ->getQuery()
                    ->getArrayResult()
        ;
    }
}
