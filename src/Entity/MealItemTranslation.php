<?php

namespace App\Entity;

use App\Repository\MealItemTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass=MealItemTranslationRepository::class)
 */
class MealItemTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity=Meal::class, inversedBy="translations")
     */
    protected $object;

    /**
     * MealItemTranslation constructor.
     * @param string $locale
     * @param string $field
     * @param string $value
     */
    public function __construct(string $locale, string $field, string $value)
    {
        $this->setLocale($locale);
        $this->setField($field);
        $this->setContent($value);
    }
}
