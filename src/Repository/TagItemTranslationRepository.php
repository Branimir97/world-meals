<?php

namespace App\Repository;

use App\Entity\TagItemTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TagItemTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method TagItemTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method TagItemTranslation[]    findAll()
 * @method TagItemTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TagItemTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TagItemTranslation::class);
    }
}
