<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HuntCatRepository")
 */
class HuntCat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="huntCats")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Hunt", mappedBy="huntCat")
     */
    private $monster;

    public function __construct()
    {
        $this->monster = new ArrayCollection();
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
     * @return Collection|Hunt[]
     */
    public function getMonster(): Collection
    {
        return $this->monster;
    }

    public function addMonster(Hunt $monster): self
    {
        if (!$this->monster->contains($monster)) {
            $this->monster[] = $monster;
            $monster->setHuntCat($this);
        }

        return $this;
    }

    public function removeMonster(Hunt $monster): self
    {
        if ($this->monster->contains($monster)) {
            $this->monster->removeElement($monster);
            // set the owning side to null (unless already changed)
            if ($monster->getHuntCat() === $this) {
                $monster->setHuntCat(null);
            }
        }

        return $this;
    }
}
