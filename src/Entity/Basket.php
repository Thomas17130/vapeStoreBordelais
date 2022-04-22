<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    private $user;

    #[ORM\ManyToMany(targetEntity: EliquidProducts::class, inversedBy: 'baskets')]
    private $eliquidProducts;

    #[ORM\ManyToMany(targetEntity: BoxProducts::class, inversedBy: 'baskets')]
    private $boxProducts;

    public function __construct()
    {
        $this->eliquidProducts = new ArrayCollection();
        $this->boxProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, eliquidProducts>
     */
    public function getEliquidProducts(): Collection
    {
        return $this->eliquidProducts;
    }

    public function addEliquidProduct(eliquidProducts $eliquidProduct): self
    {
        if (!$this->eliquidProducts->contains($eliquidProduct)) {
            $this->eliquidProducts[] = $eliquidProduct;
        }

        return $this;
    }

    public function removeEliquidProduct(eliquidProducts $eliquidProduct): self
    {
        $this->eliquidProducts->removeElement($eliquidProduct);

        return $this;
    }

    /**
     * @return Collection<int, boxProducts>
     */
    public function getBoxProducts(): Collection
    {
        return $this->boxProducts;
    }

    public function addBoxProduct(boxProducts $boxProduct): self
    {
        if (!$this->boxProducts->contains($boxProduct)) {
            $this->boxProducts[] = $boxProduct;
        }

        return $this;
    }

    public function removeBoxProduct(boxProducts $boxProduct): self
    {
        $this->boxProducts->removeElement($boxProduct);

        return $this;
    }
}
