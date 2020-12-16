<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Translatable\Translatable;

// * @Gedmo\SoftDeleteable(fieldName="deletedAt", timeAware=false)

/**
 * @ORM\Entity(repositoryClass=MealRepository::class)
 * @ORM\HasLifecycleCallbacks,
 * @Gedmo\TranslationEntity(class="App\Entity\MealItemTranslation")
 */
class Meal implements Translatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="meals")
     */
    private $category;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, mappedBy="meals")
     */
    private $tags;

    /**
     * @ORM\ManyToMany(targetEntity=Ingredient::class, mappedBy="meals")
     */
    private $ingredients;

//    /**
//     * @ORM\Column(type="datetime", nullable=true)
//     * @Gedmo\Timestampable(on="create")
//     */
//    private $createdAt;
//
//    /**
//     * @ORM\Column(type="datetime", nullable=true)
//     * @Gedmo\Timestampable(on="update")
//     */
//    private $updatedAt;
//
//    /**
//     * @ORM\Column(name="deleted_at", type="datetime", nullable=true)
//     */
//    private $deletedAt;

    /**
     * @Gedmo\Locale
     */
    private $locale;

    /**
     * @ORM\OneToMany(targetEntity=MealItemTranslation::class, mappedBy="object")
     */
    private $translations;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="meal", orphanRemoval=true)
     */
    private $statuses;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->ingredients = new ArrayCollection();
        $this->translations = new ArrayCollection();
        $this->statuses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->addMeal($this);
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        if ($this->tags->removeElement($tag)) {
            $tag->removeMeal($this);
        }

        return $this;
    }

    /**
     * @return Collection|Ingredient[]
     */
    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
            $ingredient->addMeal($this);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        if ($this->ingredients->removeElement($ingredient)) {
            $ingredient->removeMeal($this);
        }

        return $this;
    }

//    /**
//     * @ORM\PrePersist
//     */
//    public function setCreatedAt()
//    {
//        $this->createdAt = new \DateTime();
//    }
//
//    /**
//     * @ORM\PreUpdate
//     */
//    public function setUpdatedAt()
//    {
//        $this->updatedAt = new \DateTime();
//    }


//    /**
//     * @param mixed $deletedAt
//     */
//    public function setDeletedAt($deletedAt): void
//    {
//        $this->deletedAt = $deletedAt;
//        $this->status = 'deleted';
//    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale): void
    {
        $this->locale = $locale;
    }

    /**
     * @return Collection|MealItemTranslation[]
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    public function addTranslation(MealItemTranslation $translation): self
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    public function removeTranslation(MealItemTranslation $translation): self
    {
        if ($this->translations->removeElement($translation)) {
            // set the owning side to null (unless already changed)
            if ($translation->getObject() === $this) {
                $translation->setObject(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setMeal($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->statuses->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getMeal() === $this) {
                $status->setMeal(null);
            }
        }

        return $this;
    }
}
