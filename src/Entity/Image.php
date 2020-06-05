<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="images")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"image:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"image:read"})
     */
    private $alt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritory", mappedBy="image")
     */
    private $boostTerritories;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="image")
     */
    private $constructions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Familiar", mappedBy="imageBackground")
     */
    private $familiarBackground;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Familiar", mappedBy="imageHead")
     */
    private $familiarHead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImageCat", inversedBy="image")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hunt", mappedBy="huntImage")
     */
    private $huntImage;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hunt", mappedBy="huntHead")
     */
    private $huntHead;

    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        return $this->alt;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function __construct()
    {
        $this->boostTerritories = new ArrayCollection();
        $this->constructions = new ArrayCollection();
        $this->familiarBackground = new ArrayCollection();
        $this->familiarHead = new ArrayCollection();
        $this->researches = new ArrayCollection();
        $this->huntImages = new ArrayCollection();
        $this->huntHs = new ArrayCollection();
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAlt(): ?string
    {
        return $this->alt;
    }

    public function setAlt(string $alt): self
    {
        $this->alt = $alt;

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
            $boostTerritory->setImage($this);
        }

        return $this;
    }

    public function removeBoostTerritory(BoostTerritory $boostTerritory): self
    {
        if ($this->boostTerritories->contains($boostTerritory)) {
            $this->boostTerritories->removeElement($boostTerritory);
            // set the owning side to null (unless already changed)
            if ($boostTerritory->getImage() === $this) {
                $boostTerritory->setImage(null);
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
            $construction->setImage($this);
        }

        return $this;
    }

    public function removeConstruction(Construction $construction): self
    {
        if ($this->constructions->contains($construction)) {
            $this->constructions->removeElement($construction);
            // set the owning side to null (unless already changed)
            if ($construction->getImage() === $this) {
                $construction->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Familiar[]
     */
    public function getFamiliarBackground(): Collection
    {
        return $this->familiarBackground;
    }

    public function addFamiliarBackground(Familiar $familiarBackground): self
    {
        if (!$this->familiarBackground->contains($familiarBackground)) {
            $this->familiarBackground[] = $familiarBackground;
            $familiarBackground->setImageBackground($this);
        }

        return $this;
    }

    public function removeFamiliarBackground(Familiar $familiarBackground): self
    {
        if ($this->familiarBackground->contains($familiarBackground)) {
            $this->familiarBackground->removeElement($familiarBackground);
            // set the owning side to null (unless already changed)
            if ($familiarBackground->getImageBackground() === $this) {
                $familiarBackground->setImageBackground(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Familiar[]
     */
    public function getFamiliarHead(): Collection
    {
        return $this->familiarHead;
    }

    public function addFamiliarHead(Familiar $familiarHead): self
    {
        if (!$this->familiarHead->contains($familiarHead)) {
            $this->familiarHead[] = $familiarHead;
            $familiarHead->setImageHead($this);
        }

        return $this;
    }

    public function removeFamiliarHead(Familiar $familiarHead): self
    {
        if ($this->familiarHead->contains($familiarHead)) {
            $this->familiarHead->removeElement($familiarHead);
            // set the owning side to null (unless already changed)
            if ($familiarHead->getImageHead() === $this) {
                $familiarHead->setImageHead(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?ImageCat
    {
        return $this->category;
    }

    public function setCategory(?ImageCat $category): self
    {
        $this->category = $category;

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
            $research->setImage($this);
        }

        return $this;
    }

    public function removeResearch(Research $research): self
    {
        if ($this->researches->contains($research)) {
            $this->researches->removeElement($research);
            // set the owning side to null (unless already changed)
            if ($research->getImage() === $this) {
                $research->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hunt[]
     */
    public function getHuntHead(): Collection
    {
        return $this->huntH;
    }

    public function addHuntHead(Hunt $huntH): self
    {
        if (!$this->$huntHs->contains($huntH)) {
            $this->$huntHs[] = $huntH;
            $huntH->setImage($this);
        }

        return $this;
    }

    public function removeHuntHead(Hunt $huntH): self
    {
        if ($this->$huntHs->contains($huntH)) {
            $this->$huntHs->removeElement($huntH);
            // set the owning side to null (unless already changed)
            if ($huntH->getImage() === $this) {
                $huntH->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Hunt[]
     */
    public function getHuntImage(): Collection
    {
        return $this->$huntI;
    }

    public function addHuntImage(Hunt $huntI): self
    {
        if (!$this->$huntImages->contains($huntI)) {
            $this->$huntImages[] = $huntI;
            $huntI->setImage($this);
        }

        return $this;
    }

    public function removeHuntImage(Hunt $huntI): self
    {
        if ($this->$huntImages->contains($huntI)) {
            $this->$huntImages->removeElement($huntI);
            // set the owning side to null (unless already changed)
            if ($huntI->getImage() === $this) {
                $huntI->setImage(null);
            }
        }

        return $this;
    }
}
