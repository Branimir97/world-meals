<?php

namespace App\Repository;

use App\Entity\CategoryItemTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategoryItemTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategoryItemTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategoryItemTranslation[]    findAll()
 * @method CategoryItemTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryItemTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategoryItemTranslation::class);
    }
}
