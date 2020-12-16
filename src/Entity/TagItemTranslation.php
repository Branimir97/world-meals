<?php

namespace App\Entity;

use App\Repository\TagItemTranslationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity(repositoryClass=TagItemTranslationRepository::class)
 */
class TagItemTranslation extends AbstractPersonalTranslation
{

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="translations")
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
