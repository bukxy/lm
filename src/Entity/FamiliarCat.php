<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FamiliarCatRepository")
 */
class FamiliarCat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="familiarCats")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Familiar", mappedBy="familiarCat")
     */
    private $familiar;

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
        $this->familiar = new ArrayCollection();
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
     * @return Collection|Familiar[]
     */
    public function getFamiliar(): Collection
    {
        return $this->familiar;
    }

    public function addFamiliar(Familiar $familiar): self
    {
        if (!$this->familiar->contains($familiar)) {
            $this->familiar[] = $familiar;
            $familiar->setFamiliarCat($this);
        }

        return $this;
    }

    public function removeFamiliar(Familiar $familiar): self
    {
        if ($this->familiar->contains($familiar)) {
            $this->familiar->removeElement($familiar);
            // set the owning side to null (unless already changed)
            if ($familiar->getFamiliarCat() === $this) {
                $familiar->setFamiliarCat(null);
            }
        }

        return $this;
    }
}
