<?php

namespace App\Entity;

use App\Repository\FlavorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlavorRepository::class)]
class Flavor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $FlavorDescription = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'flavors')]
    private Collection $Ingredients;

    #[ORM\ManyToOne(inversedBy: 'Flavor')]
    private ?Choose $choose = null;

    public function __construct()
    {
        $this->Ingredients = new ArrayCollection();
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

    public function getFlavorDescription(): ?string
    {
        return $this->FlavorDescription;
    }

    public function setFlavorDescription(?string $FlavorDescription): static
    {
        $this->FlavorDescription = $FlavorDescription;

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getIngredients(): Collection
    {
        return $this->Ingredients;
    }

    public function addIngredient(Ingredient $ingredient): static
    {
        if (!$this->Ingredients->contains($ingredient)) {
            $this->Ingredients->add($ingredient);
        }

        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): static
    {
        $this->Ingredients->removeElement($ingredient);

        return $this;
    }

    public function getChoose(): ?Choose
    {
        return $this->choose;
    }

    public function setChoose(?Choose $choose): static
    {
        $this->choose = $choose;

        return $this;
    }
}
