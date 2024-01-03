<?php

namespace App\Entity;

use App\Repository\ChooseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChooseRepository::class)]
class Choose
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\OneToMany(mappedBy: 'choose', targetEntity: Product::class)]
    private Collection $Products;

    #[ORM\OneToMany(mappedBy: 'choose', targetEntity: Flavor::class)]
    private Collection $Flavor;

    public function __construct()
    {
        $this->Products = new ArrayCollection();
        $this->Flavor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
            $product->setChoose($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->Products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getChoose() === $this) {
                $product->setChoose(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Flavor>
     */
    public function getFlavor(): Collection
    {
        return $this->Flavor;
    }

    public function addFlavor(Flavor $flavor): static
    {
        if (!$this->Flavor->contains($flavor)) {
            $this->Flavor->add($flavor);
            $flavor->setChoose($this);
        }

        return $this;
    }

    public function removeFlavor(Flavor $flavor): static
    {
        if ($this->Flavor->removeElement($flavor)) {
            // set the owning side to null (unless already changed)
            if ($flavor->getChoose() === $this) {
                $flavor->setChoose(null);
            }
        }

        return $this;
    }
}
