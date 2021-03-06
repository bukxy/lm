<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoostTerritoryRepository")
 */
class BoostTerritory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("boost:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="boostTerritories")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("boost:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("boost:read")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="boostTerritories")
     * @Groups("boost:read")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BoostTerritoryCat", inversedBy="boostTerritory")
     */
    private $category;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?BoostTerritoryCat
    {
        return $this->category;
    }

    public function setCategory(?BoostTerritoryCat $category): self
    {
        $this->category = $category;

        return $this;
    }
}
