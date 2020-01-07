<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConstructionCatRepository")
 */
class ConstructionCat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="constructionCats")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Construction", mappedBy="constructionCat")
     */
    private $construction;

    public function __construct()
    {
        $this->construction = new ArrayCollection();
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
     * @return Collection|Construction[]
     */
    public function getConstruction(): Collection
    {
        return $this->construction;
    }

    public function addConstruction(Construction $construction): self
    {
        if (!$this->construction->contains($construction)) {
            $this->construction[] = $construction;
            $construction->setConstructionCat($this);
        }

        return $this;
    }

    public function removeConstruction(Construction $construction): self
    {
        if ($this->construction->contains($construction)) {
            $this->construction->removeElement($construction);
            // set the owning side to null (unless already changed)
            if ($construction->getConstructionCat() === $this) {
                $construction->setConstructionCat(null);
            }
        }

        return $this;
    }
}
