<?php

namespace App\Entity;

use App\Repository\IngredientItemTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass=IngredientItemTranslationRepository::class)
 */
class IngredientItemTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity=Ingredient::class, inversedBy="translations")
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
