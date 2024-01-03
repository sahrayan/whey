<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?int $volume = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $benefits = null;

    #[ORM\Column(length: 255)]
    private ?string $imgProduct = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $nutritionalPropreties = null;

    #[ORM\ManyToOne(inversedBy: 'Products')]
    private ?Choose $choose = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'Product')]
    private ?Contain $contain = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(int $volume): static
    {
        $this->volume = $volume;

        return $this;
    }

    public function getBenefits(): ?string
    {
        return $this->benefits;
    }

    public function setBenefits(string $benefits): static
    {
        $this->benefits = $benefits;

        return $this;
    }

    public function getImgProduct(): ?string
    {
        return $this->imgProduct;
    }

    public function setImgProduct(string $imgProduct): static
    {
        $this->imgProduct = $imgProduct;

        return $this;
    }

    public function getNutritionalPropreties(): ?string
    {
        return $this->nutritionalPropreties;
    }

    public function setNutritionalPropreties(?string $nutritionalPropreties): static
    {
        $this->nutritionalPropreties = $nutritionalPropreties;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getContain(): ?Contain
    {
        return $this->contain;
    }

    public function setContain(?Contain $contain): static
    {
        $this->contain = $contain;

        return $this;
    }
}
