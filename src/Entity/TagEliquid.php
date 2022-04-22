<?php

namespace App\Entity;

use App\Repository\TagEliquidRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagEliquidRepository::class)]
class TagEliquid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $booster;

    #[ORM\Column(type: 'string', length: 255)]
    private $base;

    #[ORM\Column(type: 'string', length: 255)]
    private $flavor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBooster(): ?string
    {
        return $this->booster;
    }

    public function setBooster(string $booster): self
    {
        $this->booster = $booster;

        return $this;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function setBase(string $base): self
    {
        $this->base = $base;

        return $this;
    }

    public function getFlavor(): ?string
    {
        return $this->flavor;
    }

    public function setFlavor(string $flavor): self
    {
        $this->flavor = $flavor;

        return $this;
    }
}
