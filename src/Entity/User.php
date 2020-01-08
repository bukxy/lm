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
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritory", mappedBy="user")
     */
    private $boostTerritories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BTCategory", mappedBy="user")
     */
    private $bTCategories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="user")
     */
    private $constructions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConstructionCat", mappedBy="user")
     */
    private $constructionCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageCat", mappedBy="user")
     */
    private $imageCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Research", mappedBy="user")
     */
    private $researches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ResearchCat", mappedBy="user")
     */
    private $researchCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Familiar", mappedBy="user")
     */
    private $familiars;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FamiliarCat", mappedBy="user")
     */
    private $familiarCats;

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
        $this->constructions = new ArrayCollection();
        $this->constructionCats = new ArrayCollection();
        $this->imageCats = new ArrayCollection();
        $this->researches = new ArrayCollection();
        $this->researchCats = new ArrayCollection();
        $this->familiars = new ArrayCollection();
        $this->familiarCats = new ArrayCollection();
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
     * @return Collection|Construction[]
     */
    public function getConstructions(): Collection
    {
        return $this->constructions;
    }

    public function addConstruction(Construction $construction): self
    {
        if (!$this->constructions->contains($construction)) {
            $this->constructions[] = $construction;
            $construction->setUser($this);
        }

        return $this;
    }

    public function removeConstruction(Construction $construction): self
    {
        if ($this->constructions->contains($construction)) {
            $this->constructions->removeElement($construction);
            // set the owning side to null (unless already changed)
            if ($construction->getUser() === $this) {
                $construction->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ConstructionCat[]
     */
    public function getConstructionCats(): Collection
    {
        return $this->constructionCats;
    }

    public function addConstructionCat(ConstructionCat $constructionCat): self
    {
        if (!$this->constructionCats->contains($constructionCat)) {
            $this->constructionCats[] = $constructionCat;
            $constructionCat->setUser($this);
        }

        return $this;
    }

    public function removeConstructionCat(ConstructionCat $constructionCat): self
    {
        if ($this->constructionCats->contains($constructionCat)) {
            $this->constructionCats->removeElement($constructionCat);
            // set the owning side to null (unless already changed)
            if ($constructionCat->getUser() === $this) {
                $constructionCat->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ImageCat[]
     */
    public function getImageCats(): Collection
    {
        return $this->imageCats;
    }

    public function addImageCat(ImageCat $imageCat): self
    {
        if (!$this->imageCats->contains($imageCat)) {
            $this->imageCats[] = $imageCat;
            $imageCat->setUser($this);
        }

        return $this;
    }

    public function removeImageCat(ImageCat $imageCat): self
    {
        if ($this->imageCats->contains($imageCat)) {
            $this->imageCats->removeElement($imageCat);
            // set the owning side to null (unless already changed)
            if ($imageCat->getUser() === $this) {
                $imageCat->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Research[]
     */
    public function getResearches(): Collection
    {
        return $this->researches;
    }

    public function addResearch(Research $research): self
    {
        if (!$this->researches->contains($research)) {
            $this->researches[] = $research;
            $research->setUser($this);
        }

        return $this;
    }

    public function removeResearch(Research $research): self
    {
        if ($this->researches->contains($research)) {
            $this->researches->removeElement($research);
            // set the owning side to null (unless already changed)
            if ($research->getUser() === $this) {
                $research->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResearchCat[]
     */
    public function getResearchCats(): Collection
    {
        return $this->researchCats;
    }

    public function addResearchCat(ResearchCat $researchCat): self
    {
        if (!$this->researchCats->contains($researchCat)) {
            $this->researchCats[] = $researchCat;
            $researchCat->setUser($this);
        }

        return $this;
    }

    public function removeResearchCat(ResearchCat $researchCat): self
    {
        if ($this->researchCats->contains($researchCat)) {
            $this->researchCats->removeElement($researchCat);
            // set the owning side to null (unless already changed)
            if ($researchCat->getUser() === $this) {
                $researchCat->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Familiar[]
     */
    public function getFamiliars(): Collection
    {
        return $this->familiars;
    }

    public function addFamiliar(Familiar $familiar): self
    {
        if (!$this->familiars->contains($familiar)) {
            $this->familiars[] = $familiar;
            $familiar->setUser($this);
        }

        return $this;
    }

    public function removeFamiliar(Familiar $familiar): self
    {
        if ($this->familiars->contains($familiar)) {
            $this->familiars->removeElement($familiar);
            // set the owning side to null (unless already changed)
            if ($familiar->getUser() === $this) {
                $familiar->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FamiliarCat[]
     */
    public function getFamiliarCats(): Collection
    {
        return $this->familiarCats;
    }

    public function addFamiliarCat(FamiliarCat $familiarCat): self
    {
        if (!$this->familiarCats->contains($familiarCat)) {
            $this->familiarCats[] = $familiarCat;
            $familiarCat->setUser($this);
        }

        return $this;
    }

    public function removeFamiliarCat(FamiliarCat $familiarCat): self
    {
        if ($this->familiarCats->contains($familiarCat)) {
            $this->familiarCats->removeElement($familiarCat);
            // set the owning side to null (unless already changed)
            if ($familiarCat->getUser() === $this) {
                $familiarCat->setUser(null);
            }
        }

        return $this;
    }
}
