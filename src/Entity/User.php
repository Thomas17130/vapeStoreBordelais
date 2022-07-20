<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private $email;

    #[ORM\Column(type: 'json')]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $lastname;

    #[ORM\Column(type: 'date')]
    private $dateOfBirth;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: EliquidProducts::class)]
    private $eliquidProducts;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BoxProducts::class)]
    private $boxProducts;

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: Cart::class, cascade: ['persist', 'remove'])]
    private $cart;

    public function __construct()
    {
        $this->eliquidProducts = new ArrayCollection();
        $this->boxProducts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_ADMIN';
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection<int, EliquidProducts>
     */
    public function getProduct(): Collection
    {
        return $this->eliquidProducts;
    }

    public function addProduct(EliquidProducts $eliquidProduct): self
    {
        if (!$this->eliquidProducts->contains($eliquidProduct)) {
            $this->eliquidProducts[] = $eliquidProduct;
            $eliquidProduct->setUser($this);
        }

        return $this;
    }

    public function removeProduct(EliquidProducts $eliquidProduct): self
    {
        if ($this->eliquidProducts->removeElement($eliquidProduct)) {
            // set the owning side to null (unless already changed)
            if ($eliquidProduct->getUser() === $this) {
                $eliquidProduct->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoxProducts>
     */
    public function getBoxProducts(): Collection
    {
        return $this->boxProducts;
    }

    public function addBoxProduct(BoxProducts $boxProduct): self
    {
        if (!$this->boxProducts->contains($boxProduct)) {
            $this->boxProducts[] = $boxProduct;
            $boxProduct->setUser($this);
        }

        return $this;
    }

    public function removeBoxProduct(BoxProducts $boxProduct): self
    {
        if ($this->boxProducts->removeElement($boxProduct)) {
            // set the owning side to null (unless already changed)
            if ($boxProduct->getUser() === $this) {
                $boxProduct->setUser(null);
            }
        }

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): self
    {
        // set the owning side of the relation if necessary
        if ($cart->getUser() !== $this) {
            $cart->setUser($this);
        }

        $this->cart = $cart;

        return $this;
    }
}
