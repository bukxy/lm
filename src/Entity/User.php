<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construct", mappedBy="user")
     */
    private $constructs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritory", mappedBy="user")
     */
    private $boostTerritories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BTCategory", mappedBy="user")
     */
    private $bTCategories;

    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->email;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function __construct()
    {
        $this->constructs = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->boostTerritories = new ArrayCollection();
        $this->bTCategories = new ArrayCollection();
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection|Construct[]
     */
    public function getConstructs(): Collection
    {
        return $this->constructs;
    }

    public function addConstruct(Construct $construct): self
    {
        if (!$this->constructs->contains($construct)) {
            $this->constructs[] = $construct;
            $construct->setUser($this);
        }

        return $this;
    }

    public function removeConstruct(Construct $construct): self
    {
        if ($this->constructs->contains($construct)) {
            $this->constructs->removeElement($construct);
            // set the owning side to null (unless already changed)
            if ($construct->getUser() === $this) {
                $construct->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setUser($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getUser() === $this) {
                $image->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BoostTerritory[]
     */
    public function getBoostTerritories(): Collection
    {
        return $this->boostTerritories;
    }

    public function addBoostTerritory(BoostTerritory $boostTerritory): self
    {
        if (!$this->boostTerritories->contains($boostTerritory)) {
            $this->boostTerritories[] = $boostTerritory;
            $boostTerritory->setUser($this);
        }

        return $this;
    }

    public function removeBoostTerritory(BoostTerritory $boostTerritory): self
    {
        if ($this->boostTerritories->contains($boostTerritory)) {
            $this->boostTerritories->removeElement($boostTerritory);
            // set the owning side to null (unless already changed)
            if ($boostTerritory->getUser() === $this) {
                $boostTerritory->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|BTCategory[]
     */
    public function getBTCategories(): Collection
    {
        return $this->bTCategories;
    }

    public function addBTCategory(BTCategory $bTCategory): self
    {
        if (!$this->bTCategories->contains($bTCategory)) {
            $this->bTCategories[] = $bTCategory;
            $bTCategory->setUser($this);
        }

        return $this;
    }

    public function removeBTCategory(BTCategory $bTCategory): self
    {
        if ($this->bTCategories->contains($bTCategory)) {
            $this->bTCategories->removeElement($bTCategory);
            // set the owning side to null (unless already changed)
            if ($bTCategory->getUser() === $this) {
                $bTCategory->setUser(null);
            }
        }

        return $this;
    }
}
