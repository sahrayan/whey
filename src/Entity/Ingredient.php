<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ingredientDescription = null;

    #[ORM\Column]
    private ?bool $allergens = null;

    #[ORM\ManyToMany(targetEntity: Flavor::class, mappedBy: 'Ingredients')]
    private Collection $flavors;

    public function __construct()
    {
        $this->flavors = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getIngredientDescription(): ?string
    {
        return $this->ingredientDescription;
    }

    public function setIngredientDescription(?string $ingredientDescription): static
    {
        $this->ingredientDescription = $ingredientDescription;

        return $this;
    }

    public function isAllergens(): ?bool
    {
        return $this->allergens;
    }

    public function setAllergens(bool $allergens): static
    {
        $this->allergens = $allergens;

        return $this;
    }

    /**
     * @return Collection<int, Flavor>
     */
    public function getFlavors(): Collection
    {
        return $this->flavors;
    }

    public function addFlavor(Flavor $flavor): static
    {
        if (!$this->flavors->contains($flavor)) {
            $this->flavors->add($flavor);
            $flavor->addIngredient($this);
        }

        return $this;
    }

    public function removeFlavor(Flavor $flavor): static
    {
        if ($this->flavors->removeElement($flavor)) {
            $flavor->removeIngredient($this);
        }

        return $this;
    }
}
