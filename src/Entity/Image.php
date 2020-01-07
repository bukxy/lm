<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $alt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BoostTerritory", mappedBy="image")
     */
    private $boostTs;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="image")
     */
    private $constructions;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ImageCat", inversedBy="image")
     */
    private $imageCat;

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
        $this->boostTs = new ArrayCollection();
        $this->constructions = new ArrayCollection();
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
    public function getBoostTs(): Collection
    {
        return $this->boostTs;
    }

    public function addBoostT(BoostTerritory $boost): self
    {
        if (!$this->boostTs->contains($boost)) {
            $this->boostTs[] = $boost;
            $boost->setImage($this);
        }

        return $this;
    }

    public function removeBoostT(BoostTerritory $boost): self
    {
        if ($this->boostTs->contains($boost)) {
            $this->boostTs->removeElement($boost);
            // set the owning side to null (unless already changed)
            if ($boost->getImage() === $this) {
                $boost->setImage(null);
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

    public function getImageCat(): ?ImageCat
    {
        return $this->imageCat;
    }

    public function setImageCat(?ImageCat $imageCat): self
    {
        $this->imageCat = $imageCat;

        return $this;
    }
}
