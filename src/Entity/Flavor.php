<?php

namespace App\Entity;

use App\Repository\FlavorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Flavor;


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
    private ?string $flavorDescription = null;

    #[ORM\ManyToMany(targetEntity: Ingredient::class, inversedBy: 'flavors')]
    private Collection $ingredients;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'flavors')]
    private Collection $products;

    #[ORM\ManyToOne(inversedBy: 'flavors')]
    private ?Choose $choose = null;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getFlavorDescription(): ?string
    {
        return $this->flavorDescription;
    }

    public function setFlavorDescription(?string $flavorDescription): self
    {
        $this->flavorDescription = $flavorDescription;
        return $this;
    }

    public function getIngredients(): Collection
    {
        return $this->ingredients;
    }

    public function addIngredient(Ingredient $ingredient): self
    {
        if (!$this->ingredients->contains($ingredient)) {
            $this->ingredients[] = $ingredient;
        }
        return $this;
    }

    public function removeIngredient(Ingredient $ingredient): self
    {
        $this->ingredients->removeElement($ingredient);
        return $this;
    }

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addFlavor($this); // Assurez-vous que la méthode addFlavor() existe dans Product
        }
        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeFlavor($this); // Assurez-vous que la méthode removeFlavor() existe dans Product
        }
        return $this;
    }

    public function getChoose(): ?Choose
    {
        return $this->choose;
    }

    public function setChoose(?Choose $choose): self
    {
        $this->choose = $choose;
        return $this;
    }
}
