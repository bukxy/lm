<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HuntRepository")
 */
class Hunt
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("huntByCat:read")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="hunts")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("huntByCat:read")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="huntImage")
     * @Groups("huntByCat:read")
     */
    private $huntImage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Image", inversedBy="huntHead")
     */
    private $huntHead;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\HuntCat", inversedBy="monster")
     */
    private $huntCat;

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

    public function getHuntImage(): ?Image
    {
        return $this->huntImage;
    }

    public function sethuntImage(?Image $huntImage): self
    {
        $this->huntImage = $huntImage;

        return $this;
    }

    public function getHuntHead(): ?Image
    {
        return $this->huntHead;
    }

    public function setHuntHead(?Image $huntHead): self
    {
        $this->huntHead = $huntHead;

        return $this;
    }

    public function getHuntCat(): ?HuntCat
    {
        return $this->huntCat;
    }

    public function setHuntCat(?HuntCat $huntCat): self
    {
        $this->huntCat = $huntCat;

        return $this;
    }
}
