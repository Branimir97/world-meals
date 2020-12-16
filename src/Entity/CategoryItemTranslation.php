<?php

namespace App\Entity;

use App\Repository\CategoryItemTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass=CategoryItemTranslationRepository::class)
 */
class CategoryItemTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="translations")
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
