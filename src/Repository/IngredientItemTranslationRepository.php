<?php

namespace App\Repository;

use App\Entity\IngredientItemTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IngredientItemTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method IngredientItemTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method IngredientItemTranslation[]    findAll()
 * @method IngredientItemTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IngredientItemTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IngredientItemTranslation::class);
    }
}
