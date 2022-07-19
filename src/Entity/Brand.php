<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\OneToOne(mappedBy: 'brand', targetEntity: EliquidProducts::class, cascade: ['persist', 'remove'])]
    private $eliquids;

    public function __construct()
    {
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

    /**
     * @return Collection<int, Product>
     */
    public function __toString()
    {
        return $this->name;
    }
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function getEliquids(): ?EliquidProducts
    {
        return $this->eliquids;
    }

    public function setEliquids(?EliquidProducts $eliquids): self
    {
        // unset the owning side of the relation if necessary
        if ($eliquids === null && $this->eliquids !== null) {
            $this->eliquids->setBrand(null);
        }

        // set the owning side of the relation if necessary
        if ($eliquids !== null && $eliquids->getBrand() !== $this) {
            $eliquids->setBrand($this);
        }

        $this->eliquids = $eliquids;

        return $this;
    }
}
