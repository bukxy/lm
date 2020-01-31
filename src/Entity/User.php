<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="Adresse mail dèjà utilisé")
 * @UniqueEntity(fields={"pseudo"}, message="Pseudo déjà utilisé")
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
     * @Assert\Email(message="Adresse mail non valide")
     * @Assert\NotBlank(message="Adresse mail obligatoire")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     * @Assert\NotBlank(message="Pseudo obligatoire")
     * @Assert\Length(
     *      min = 3,
     *      minMessage = "Le pseudo doit faire au minimum {{ limit }} characters",
     *      max = 30,
     *      maxMessage = "Le pseudo doit faire au maximum {{ limit }} characters"
     * )
     */
    private $pseudo;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 6,
     *      minMessage = "Votre mot de passe doit faire au minimum {{ limit }} characters",
     *      max = 255,
     *      maxMessage = "Votre mot de passe doit faire au maximum {{ limit }} characters"
     * )
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="user")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritory", mappedBy="user")
     */
    private $boostTerritories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritoryCat", mappedBy="user")
     */
    private $boostTerritoryCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="user")
     */
    private $constructions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConstructionCat", mappedBy="user")
     */
    private $constructionCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Events", mappedBy="user")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Familiar", mappedBy="user")
     */
    private $familiars;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\FamiliarCat", mappedBy="user")
     */
    private $familiarCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ImageCat", mappedBy="user")
     */
    private $imageCats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Research", mappedBy="user")
     */
    private $researches;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserRank", inversedBy="users")
     */
    private $rank;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserAccountActivation", inversedBy="user")
     */
    private $activation;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->boostTerritories = new ArrayCollection();
        $this->boostTerritoryCats = new ArrayCollection();
        $this->constructions = new ArrayCollection();
        $this->constructionCats = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->familiars = new ArrayCollection();
        $this->familiarCats = new ArrayCollection();
        $this->imageCats = new ArrayCollection();
        $this->researches = new ArrayCollection();
        $this->researchCats = new ArrayCollection();
    }

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

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

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
     * @return Collection|BoostTerritoryCat[]
     */
    public function getBoostTerritoryCats(): Collection
    {
        return $this->boostTerritoryCats;
    }

    public function addBoostTerritoryCat(BoostTerritoryCat $boostTerritoryCat): self
    {
        if (!$this->boostTerritoryCats->contains($boostTerritoryCat)) {
            $this->boostTerritoryCats[] = $boostTerritoryCat;
            $boostTerritoryCat->setUser($this);
        }

        return $this;
    }

    public function removeBoostTerritoryCat(BoostTerritoryCat $boostTerritoryCat): self
    {
        if ($this->boostTerritoryCats->contains($boostTerritoryCat)) {
            $this->boostTerritoryCats->removeElement($boostTerritoryCat);
            // set the owning side to null (unless already changed)
            if ($boostTerritoryCat->getUser() === $this) {
                $boostTerritoryCat->setUser(null);
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
     * @return Collection|Events[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setUser($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getUser() === $this) {
                $event->setUser(null);
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

    public function getRank(): ?UserRank
    {
        return $this->rank;
    }

    public function setRank(?UserRank $rank): self
    {
        $this->rank = $rank;

        return $this;
    }

    public function getActivation(): ?UserAccountActivation
    {
        return $this->activation;
    }

    public function setActivation(?UserAccountActivation $activation): self
    {
        $this->activation = $activation;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $activation ? null : $this;
        if ($activation->getUser() !== $newUser) {
            $activation->setUser($newUser);
        }

        return $this;
    }
}