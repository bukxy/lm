<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConstructionRepository")
 */
class Construction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("construction:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="constructions")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("construction:read")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups("construction:read")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="constructions")
     * @Groups("construction:read")
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ConstructionCat", inversedBy="construction")
     */
    private $constructionCat;

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

    public function getConstructionCat(): ?ConstructionCat
    {
        return $this->constructionCat;
    }

    public function setConstructionCat(?ConstructionCat $constructionCat): self
    {
        $this->constructionCat = $constructionCat;

        return $this;
    }
}
