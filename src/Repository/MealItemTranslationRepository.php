<?php

namespace App\Repository;

use App\Entity\MealItemTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MealItemTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MealItemTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MealItemTranslation[]    findAll()
 * @method MealItemTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealItemTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MealItemTranslation::class);
    }
}
