<?php

namespace App\Repository;

use App\Entity\Meal;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Gedmo\Translatable\TranslatableListener;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    private $languageRepository;
    private $locale;
    private $errors = [];

    public function __construct(ManagerRegistry $registry, LanguageRepository $languageRepository)
    {
        parent::__construct($registry, Meal::class);
        $this->languageRepository = $languageRepository;
    }

    public function filter($filter) {
        $dbQuery = $this->createQueryBuilder('m');
        foreach ($filter as $query=>$value) {
            if($query == 'category') {
                if($value == 'null') {
                    $dbQuery->Andwhere('m.category IS null');
                    }
                    else if($value == '!null') {
                        $dbQuery->Andwhere('m.category IS NOT null');
                    } else {
                        $dbQuery->join('m.category', 'c');
                        $dbQuery->Andwhere('c.id LIKE :category_id');
                        $dbQuery->setParameter('category_id', $value);
                    }
                }

            if($query == 'tags') {
                $explodedTagIds = explode(',', $value);
                $dbQuery->join('m.tags', 't');
                $dbQuery->Andwhere('t.id IN (:tag_ids)');
                $dbQuery->setParameter('tag_ids', $explodedTagIds);
            }

            if($query == 'with') {
                $withValuesExploded = explode(',', $value);
                foreach($withValuesExploded as $withValue) {
                        $dbQuery->join('m.'.$withValue.'', 'i'.$withValue)
                            ->addSelect('i'.$withValue);
                }
            }

            if($query == 'diff_time') {
                $parsedDate = strtotime($value);
                if(!$parsedDate || $value <= 0) {
                    $this->errors = [
                        'status:'=> 'error',
                        'code:'=> 'invalid date format',
                        'message:'=> 'You entered wrong query type for diff_time!'
                    ];
                } else {
                    $date = new DateTime($value);
                    $dbQuery->join('m.statuses', 's');
                    $dbQuery->Andwhere('s.createdAt > :date');
                    $dbQuery->setParameter('date', $date);
                }
            }

            if($query == 'per_page') {
                if($value > $this->getNumberOfMeals()) {
                    $this->errors = [
                        'status:'=> 'error',
                        'code:'=> 'invalid per_page number',
                        'message:'=> 'There is/are only '.$this->getNumberOfMeals().' result/s in database!'
                    ];
                } else {
                    $dbQuery->setMaxResults($value);
                }
            }

            if($query == 'page') {
                if($value == 1) {
                    $offset = 0;
                } else {
                    $offset = $dbQuery->getMaxResults()*($value-1);
                }
                $dbQuery->setFirstResult($offset);
            }

            if($query == 'lang') {
                if(empty($this->languageRepository->checkIfExists($value))) {
                    $this->errors = [
                        'status:'=> 'error',
                        'code:'=> 'invalid lang parameter',
                        'message:'=> 'This language is not defined in our database!'
                    ];
                } else {
                    $this->locale = $value;
                    $dbQuery->join('m.translations', 'rl');
                    $dbQuery->Andwhere('rl.locale = :language');
                    $dbQuery->setParameter('language', $value);
                }
            }
        }

        $query = $dbQuery->getQuery();

        $query->setHint(TranslatableListener::HINT_TRANSLATABLE_LOCALE, $this->locale);
        $query->setHint(Query::HINT_CUSTOM_OUTPUT_WALKER,
            'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker');

        return $query->getArrayResult();
    }

    public function findAllAsArray() {
        $query = $this->createQueryBuilder('m')
            ->join('m.category', 'c')
            ->join('m.ingredients', 'i')
            ->join('m.tags', 't')
            ->addSelect('c')
            ->addSelect('i')
            ->addSelect('t');

        return $query->getQuery()->getArrayResult();
    }

    public function getNumberOfMeals() {
        $query = $this->createQueryBuilder('m')
            ->select('count(m.id)');

        return $query->getQuery()->getSingleScalarResult();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
