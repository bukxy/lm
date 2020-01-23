<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResearchCatRepository")
 */
class ResearchCat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="researchCats")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Research", mappedBy="researchCat")
     */
    private $research;

    /**
     * Generates the magic method
     * 
     */
    public function __toString(){
        // to show the name of the Category in the select
        return $this->name;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function __construct()
    {
        $this->research = new ArrayCollection();
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

    /**
     * @return Collection|Research[]
     */
    public function getResearch(): Collection
    {
        return $this->research;
    }

    public function addResearch(Research $research): self
    {
        if (!$this->research->contains($research)) {
            $this->research[] = $research;
            $research->setResearchCat($this);
        }

        return $this;
    }

    public function removeResearch(Research $research): self
    {
        if ($this->research->contains($research)) {
            $this->research->removeElement($research);
            // set the owning side to null (unless already changed)
            if ($research->getResearchCat() === $this) {
                $research->setResearchCat(null);
            }
        }

        return $this;
    }
}
